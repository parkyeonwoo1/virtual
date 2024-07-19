<?php
    session_start();
    include "../utils/common.php";
    $username = $_SESSION['login'];
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $objective = isset($_POST['objective']) ? $_POST['objective'] : '';
    $way = isset($_POST['way']) ? $_POST['way'] : '';
    $rule = isset($_POST['rule']) ? $_POST['rule'] : '';

    $title = htmlspecialchars($title);
    $objective = htmlspecialchars($objective);
    $way = htmlspecialchars($way);
    $rule = htmlspecialchars($rule);
    
    $title = str_replace("\r\n", "<br>", $title);
    $objective = str_replace("\r\n", "<br>", $objective);
    $way = str_replace("\r\n", "<br>", $way);
    $rule = str_replace("\r\n", "<br>", $rule);

    // 파일 업로드 처리
    $upload_path = '';
    if(!empty($_FILES['image']['name'])) {
        $filename = $_FILES['image']['name']; 
        $upload_path = "../uploads/".$filename; 
        $file_info = pathinfo($upload_path); 
        $ext = strtolower($file_info["extension"]);
        $ext_arr = array('jpg', 'jpeg', 'png'); 
        if(!in_array($ext, $ext_arr)){
            echo "<script>alert('허용되지 않은 확장자입니다.');history.back(-1);</script>";
            exit;
        } else if(!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)){
            echo "<script>alert('파일 업로드에 실패했습니다.');history.back(-1)</script>";
            exit;
        }
    }

    // $query = "INSERT INTO study (title, objective, way, rule, member, img) VALUES (?, ?, ?, ?, ?, ?)";
    // $stmt = $db_conn->prepare($query);
    // $member = 1;
    // $stmt->bind_param('ssssis', $title, $objective, $way, $rule, $member, $upload_path);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // if($result) {
    //     echo "<script>alert('스터디가 생성되었습니다.');self.location.href='board.php';</script>";
    //  } else {
    //     echo "<script>alert('스터디 생성에 실패했습니다.');history.back(-1);</script>";
    //     exit;
    //  }
     try {
        // SQL 쿼리 준비
        $query = "INSERT INTO study (title, objective, way, rule, member, img, name) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db_conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: (" . $db_conn->errno . ") " . $db_conn->error);
        }
    
        // 바인딩 및 실행
        $member = 1;
        $stmt->bind_param('ssssiss', $title, $objective, $way, $rule, $member, $upload_path, $username);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    
        // 성공 메시지 출력
        echo "<script>alert('스터디가 생성되었습니다.');self.location.href='./study.php';</script>";
    } catch (Exception $e) {
        // 오류 발생 시 메시지 출력
        echo "<script>alert('스터디 생성에 실패했습니다. 오류: " . $e->getMessage() . "');history.back(-1);</script>";
        exit;
    }
?>
<?php
    session_start();
    include "../../utils/common.php";

    header("Content-Type: text/html; charset=UTF-8");
    // 사용자 입력을 받아오기
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $userfile = isset($_FILES['userfile']) ? $_FILES['userfile'] : '';
    $idx = isset($_POST['idx']) ? $_POST['idx'] : '';

    if($idx == ''){
        echo "<script>alert('정상적인 값이 아닙니다.');history.back(-1);</script>";
        exit;
    }else if(preg_match("/^[0-9]*$/", $idx) == 0){
        echo "<script>alert('Check for hacking attempts. IP will be blocked if repeated.');history.back(-1)</script>";
        exit;
    }else if(mb_strlen($title) > 30){
        echo "<script>alert('Please keep the title less than 30 characters.');history.back(-1)</script>";
        exit;
    }
    // HTML 엔티티로 변환
    $filename = isset($_POST['filename']) ? $_POST['filename'] : '';
    $content = str_replace("\r\n", "<br>", $content);
    // 파일 업로드 처리
    if(!empty($_FILES['userfile']['name'])) {
        $filename = $_FILES['userfile']['name']; 
        $upload_path = "../../uploads/".$filename; 
        $file_info = pathinfo($upload_path); 
        $ext = strtolower($file_info["extension"]);
        $ext_arr = array('jpg', 'jpeg', 'png'); 
        if(!in_array($ext, $ext_arr)){
            echo "<script>alert('허용되지 않은 확장자입니다.');history.back(-1);</script>";
            exit;
        } else if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_path)){
            echo "<script>alert('파일 업로드에 실패했습니다.');history.back(-1)</script>";
            exit;
        }
    }
    $sql = "UPDATE board SET title=?, content=?, filename=?, regdate=NOW() WHERE idx=?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $content, $filename, $idx);
    $result = $stmt->execute();
    
    if($result) {
       echo "<script>alert('게시글 수정이 완료되었습니다.');</script>";
    } else {
       echo "<script>alert('게시글 수정에 실패했습니다.');</script>";
    }
    echo "<script>self.location.href='./view.php?idx=$idx';</script>";
    exit;
?>

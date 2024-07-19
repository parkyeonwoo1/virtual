<?php
session_start();
    include "../../utils/common.php";
    header("Content-Type: text/html; charset=UTF-8");
    // 사용자 입력을 받아오기
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
    $userfile = isset($_FILES['userfile']) ? $_FILES['userfile'] : '';
    $password = isset($_POST['userpass']) ? $_POST['userpass'] : '';
    $id = isset($_POST['userid']) ? $_POST['userid'] : '';
    
    if(mb_strlen($title) > 30){
        echo "<script>alert('제목은 30글자 미만으로 설정해주세요.');history.back(-1)</script>";
        exit;
    }
    // HTML 엔티티로 변환
    
    $filename = '';
    $content = str_replace("\r\n", "<br>", $content);
    $upload_path = '';
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


    // 쿼리 실행부분
    
    $query = "INSERT INTO board (title, writer, content, regdate, filename, password) values('$title', '$id', '$content',curdate(),'$filename','$password')";
    $result = $db_conn->query($query);
    if($result) {
       echo "<script>alert('게시글이 작성되었습니다.');self.location.href='../qna.php';</script>";
    } else {
       echo "<script>alert('게시글 작성에 실패했습니다.');history.back(-1);</script>";
       exit;
    }
?>

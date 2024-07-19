<?php
session_start();
    include "../utils/common.php";
    header("Content-Type: text/html; charset=UTF-8");
    // 사용자 입력을 받아오기
    $intro = isset($_POST['intro']) ? $_POST['intro'] : '';
    $curriculum = isset($_POST['curriculum']) ? $_POST['curriculum'] : '';
    $detailcurri = isset($_POST['detailcurri']) ? $_POST['detailcurri'] : '';
    $idx = isset($_POST['idx']) ? $_POST['idx'] : '';
    
    $filename = '';
    $intro = str_replace("\r\n", "<br>", $intro);

    $upload_path = '';
    if(!empty($_FILES['userfile']['name'])) {
        $filename = $_FILES['userfile']['name']; 
        $upload_path = "../images/".$filename; 
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
    
    $query = "UPDATE lecture SET intro = '$intro', curriculum = '$curriculum', detailcurri='$detailcurri', img='$upload_path' WHERE idx = $idx";

    $result = $db_conn->query($query);
    if($result) {
       echo "<script>alert('게시글이 작성되었습니다.');self.location.href='./write.php';</script>";
    } else {
       echo "<script>alert('게시글 작성에 실패했습니다.');history.back(-1);</script>";
       exit;
    }
?>

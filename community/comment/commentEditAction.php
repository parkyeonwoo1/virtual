<?php
    session_start();
    include "../../utils/common.php";
    header("Content-Type: text/html; charset=UTF-8");

    $idx = isset($_POST['idx']) ? $_POST['idx'] : 0;
    $text = isset($_POST['text']) ? $_POST['text'] : '';
    $boardidx = isset($_POST['boardidx']) ? $_POST['boardidx'] : 0;

    if(preg_match("/^[0-9]*$/", $idx) == 0){
        echo "<script>alert('정상적인 입력값이 아닙니다.');history.back(-1);</script>";
        exit;
    }else if($idx == 0){
        echo "<script>alert('정상적인 접근이 아닙니다.');history.back(-1);</script>";
        exit;
    }else if($_SESSION['login'] != 'admin'){
        echo "<script>alert('비정상적인 접근입니다.');history.back(-1);</script>";
        exit;
    }
    $text = str_replace("\r\n", "<br>", $text);

    $query = "UPDATE comments SET comment_text=? WHERE idx = ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param("si", $text, $idx);
    $result = $stmt->execute();
    if($result){
        echo "<script>alert('댓글 수정이 완료되었습니다.');location.href='../board/view.php?idx={$boardidx}';</script>";
        exit;
    }else{
        echo "<script>alert('댓글 수정에 실패했습니다.');history.back(-1);</script>";
        exit;
    }
    $stmt->close();
    $db_conn->close();
?>
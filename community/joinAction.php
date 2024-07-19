<?php
    include "../utils/common.php";
    session_start();

    $idx = isset($_GET['idx']) ? $_GET['idx'] : '';
    if (preg_match("/^[0-9]*$/", $idx) == 0 || $idx == '') {
        echo "<script>alert('정상적인 입력값이 아닙니다.');history.back(-1);</script>";
        exit;
    } elseif (!isset($_SESSION['login'])) {
        echo "<script>alert('로그인 후 이용 가능합니다.');history.back(-1);</script>";
        exit;
    }

    $query = 'SELECT * FROM study WHERE idx = ?';
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param('i', $idx);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $array = explode(",", $row['list']);
    for($i=0; $i<count($array); $i++){
        if($array[$i] == $_SESSION['login']){
            echo "<script>alert('이미 가입된 스터디입니다.');history.back(-1);</script>";
            exit;
        }
    }
    if ($row) {
        $num = $row['member'];
        $num += 1;
        $list = $row['list'] . "," . $_SESSION['login'];

        $query = "UPDATE study SET member = ?, list = ? WHERE idx = ?";
        $stmt = $db_conn->prepare($query);
        $stmt->bind_param('isi', $num, $list, $idx);
        $result = $stmt->execute();

        if ($result) {
            echo "<script>alert('스터디에 성공적으로 가입되었습니다.');window.location.href='study.php';</script>";
        } else {
            echo "<script>alert('스터디 가입에 실패했습니다.');history.back(-1);</script>";
        }
    } else {
        echo "<script>alert('스터디 정보를 가져오는데 실패했습니다.');history.back(-1);</script>";
    }
?>

<?php
    session_start();
    include "../utils/common.php";
    $username = isset($_POST['uid']) ? $_POST['uid'] : '';
    $password = isset($_POST['upw']) ? $_POST['upw'] : '';

    if ($username === '' || $password === '') {
        echo "<script>alert('아이디 또는 패스워드를 입력해 주세요.');history.back(-1);</script>";
        exit();
    }else if((preg_match("/^[0-9a-zA-Z]*$/", $username) == 0)){
        echo "<script>alert('해킹시도 확인. 반복 시 IP가 차단됩니다.');history.back(-1);</script>";
        exit;
    }

    $query = 'SELECT * FROM users WHERE username = ?';
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = ($result && $result->num_rows) ? $result->num_rows : 0;
    $row = $result->fetch_assoc();
    $real_username = isset($row['username']) ? $row['username'] : '';
    $real_password = isset($row['password']) ? $row['password'] : '';
    if($real_username == '' || $real_password == ''){
        echo "<script>alert('아이디 또는 패스워드가 일치하지 않습니다.');history.back(-1);</script>";
        exit();
    }
    $password = hash("sha256", $password);
    if ($num > 0) {
        if ($password == $real_password) {
            $_SESSION['login'] = $username;
            echo "<script>alert('" . $username . "님 반갑습니다.');window.location.href='../index.php';</script>";
            exit();
        }else {
            echo $real_password;
            echo "   ";
            echo $password;
            echo "<script>alert('아이디 또는 패스워드가 일치하지 않습니다.');history.back(-1);</script>";
            exit();
        }
    } else {
        echo "<script>alert('아이디 또는 패스워드가 일치하지 않습니다.');history.back(-1);</script>";
        exit();
    }
?>
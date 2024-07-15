<?php
    session_start();
    include "../utils/common.php";
    $username = isset($_POST['uid']) ? $_POST['uid'] : '';
    $password = isset($_POST['upw']) ? $_POST['upw'] : '';
    $password2 = isset($_POST['upw2']) ? $_POST['upw2'] : '';

    if ($username === '' || $password === '' || $password2 ===''){
        echo "<script>alert('아이디 또는 패스워드가 공백입니다.');history.back(-1);</script>";
        exit();
    }else if((preg_match("/^[0-9a-zA-Z]*$/", $username) == 0)){
        echo "<script>alert('해킹시도 확인. 반복 시 IP가 차단됩니다.');history.back(-1);</script>";
        exit;
    }else if($password != $password2){
        echo "<script>alert('패스워드가 서로 일치하지 않습니다.');history.back(-1);</script>";
        exit();
    }
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = ($result && $result->num_rows) ? $result->num_rows : 0;
    $row = $result->fetch_assoc();

    if($num > 0){
        echo "<script>alert('이미 존재하는 아이디입니다.');history.back(-1);</script>";
        exit();
    } else {
        $query = 'INSERT INTO users(username, password) VALUES(?, ?)';
        $password = hash("sha256", $password);
        $stmt = $db_conn->prepare($query);
        $stmt->bind_param('ss', $username, $password);  // 수정된 부분
        $stmt->execute();
        echo $password;
        echo "<script>alert('회원가입이 완료되었습니다.');window.location.href='./login.php'</script>";
        exit();
    }
    
?>
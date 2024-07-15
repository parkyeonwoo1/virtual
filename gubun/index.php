<?php
    include "../utils/common.php";
    session_start();

    $gubun = isset($_GET['gubun']) ? $_GET['gubun'] : '';
    $query = 'SELECT * FROM lecture';
    $result = $db_conn->query($query);
    $rows = array();
    // 레코드를 반복하여 배열에 저장
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $subjects = array(
        'sec' => array(1, 3, 5, 6),
        'game' => array(0, 2, 4, 7),
        'dbms' => array(10),
        'cs' => array(8, 9, 10, 11),
        'network' => array(),
        'cipher' => array(),
        'programming' => array(0, 2, 7, 10)
    );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./utils/main.css">
    <link rel="stylesheet" href="./utils/common.js">
    <style>
        /* 검색창에서 플레이스 홀더 글자 설정 */
        input::placeholder {
            font-size: 12px; /* placeholder 글자 크기 */
            color: grey; /* placeholder 글자 색상 (선택 사항) */
        }
        .form-control {
            width: 100%;
            max-width: 700px;
        }
        /* 중간에 있는 AI 검색창 옵션 */
        #container{
            width: 500px;
            height: 50px;
            position: relative;
            display : flex;
            margin: auto;
        }
        #container input{
            width: 150%;
            border-radius: 25px;
            padding: 20px;
        }
        #container button{
            position : absolute;
            top: 5px;
            bottom: 5px;
            right: 5px;
            border: none;
            background-color:transparent
        }
        /* 중간에 있는 AI 검색창 옵션 */

        /* 제일 상단에 있는 검색창 옵션 */
        #container2{
            width: 500px;
            height: 30px;
            position: relative;
            display : flex;
            margin: auto;
        }
        #mainsearch{
            width: 100%;
            border-radius: 10px;
            padding: 20px;
            
        }
        #container2 button{
            position : absolute;
            top: 5px;
            bottom: 5px;
            right: 5px;
            border: none;
            background-color:transparent
        }
        /* 제일 상단에 있는 검색창 옵션 */

        #lecture-img {
            display: flex;
            flex-wrap: wrap; /* 여러 줄로 감싸기 위해 추가 */
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .lecture-item {
            margin: 20px;
            text-decoration: none; /* 링크의 밑줄 제거 */
            color: #333; /* 링크 색상 설정 */
            
        }

        .lecture-item img {
            width: 50px;
            margin-top: 50px;
        }

        .lecture-item span {
            display: block;
        }
        .lecture-item a{
            text-decoration: none; /* 밑줄 제거 */
            color: inherit; /* 기본 색상 상속 */
        }

        /* 내가좋아하는 강의 목록을 나열하기 위한 CSS */
        .lecture-box {
            width: 30%;
            height: 150px;
            margin: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
        }
        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .btnbtn {
            width: 100%;
        }
        .blinking-text {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
            -webkit-background-clip: text;
            color: transparent;
            animation: rainbow 3s infinite linear, blinking 1s infinite alternate;
        }
        .logincontainer{
            width: 300px;
            height: 300px;
            margin: auto;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div style="width:80%; margin: auto; margin-top:20px">
        <!-- 부트스트랩 navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">
            <div class="container">
                <a class="navbar-brand" href="../index.php">CodeLearn</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>강의</strong>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="./index.php?gubun=sec">정보 보안</a></li>
                                <li><a class="dropdown-item" href="./index.php?gubun=game">게임 개발</a></li>
                                <li><a class="dropdown-item" href="./index.php?gubun=dbms">데이터베이스</a></li>
                                <li><a class="dropdown-item" href="./index.php?gubun=cs">컴퓨터 공학</a></li>
                                <li><a class="dropdown-item" href="./index.php?gubun=network">네트워크</a></li>
                                <li><a class="dropdown-item" href="./index.php?gubun=cipher">암호학</a></li>
                                <li><a class="dropdown-item" href="./index.php?gubun=programming">프로그래밍</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>커뮤니티</strong>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">질문 & 답변</a></li>
                                <li><a class="dropdown-item" href="#">수강평</a></li>
                                <li><a class="dropdown-item" href="#">고민있어요</a></li>
                                <li><a class="dropdown-item" href="#">스터디</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../product.php"><strong>로드맵</strong></a>
                        </li>
                        <form class="d-flex" role="search" id="container" style="width:350px" action="../search/index.php">
                            <input name="keyword" class="form-control me-2" type="search" placeholder="나의 진짜 성장을 도와줄 실무 강의를 찾아보세요" aria-label="Search" style="border-radius:10px; ">
                            <button type="submit">🔍</button>
                        </form>
                            <?php
                                if(!isset($_SESSION['login'])){

                            ?>
                            <li class="nav-item" style="flex:right">
                                <a class="nav-link" href="../login/login.php"><strong>로그인</strong></a>
                            </li>
                            <?php
                                }else{

                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../login/logout.php"><strong>로그아웃</strong></a>
                            </li>
                        <?php
                            }
                        ?>
                        <?php 
                            if(isset($_SESSION['id'])){
                                if($_SESSION['id'] == 'admin'){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../mypage/index.php">관리자님</a>
                        </li>
                        <?php
                                }else{
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../mypage/index.php"><?=$_SESSION['id']?>님</a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="lecture-img">
    <?php if ($_GET['gubun'] == 'sec'){ 
            for ($i = 0; $i < count($subjects['sec']); $i++){ ?>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture/index.php?div=<?=$subjects['sec'][$i]?>">
                    <img src="<?= $rows[$subjects['sec'][$i]]['img'] ?>" alt="<?= $rows[$subjects['sec'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                    <span><strong><?= $rows[$subjects['sec'][$i]]['name'] ?></strong></span>
                </a>
            </div>
        <?php }}else if($_GET['gubun'] == 'game'){ 
            for ($i = 0; $i < count($subjects['game']); $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$subjects['game'][$i]?>">
                        <img src="<?= $rows[$subjects['game'][$i]]['img'] ?>" alt="<?= $rows[$subjects['game'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                        <span><strong><?= $rows[$subjects['game'][$i]]['name'] ?></strong></span>
                    </a>
                </div>
        <?php }}else if($_GET['gubun'] == 'dbms'){ 
            for ($i = 0; $i < count($subjects['dbms']); $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$subjects['dbms'][$i]?>">
                        <img src="<?= $rows[$subjects['dbms'][$i]]['img'] ?>" alt="<?= $rows[$subjects['dbms'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                        <span><strong><?= $rows[$subjects['dbms'][$i]]['name'] ?></strong></span>
                    </a>
                </div>
        <?php }}else if($_GET['gubun'] == 'cs'){ 
            for ($i = 0; $i < count($subjects['cs']); $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$subjects['cs'][$i]?>">
                        <img src="<?= $rows[$subjects['cs'][$i]]['img'] ?>" alt="<?= $rows[$subjects['cs'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                        <span><strong><?= $rows[$subjects['cs'][$i]]['name'] ?></strong></span>
                    </a>
                </div>
        <?php }}else if($_GET['gubun'] == 'network'){ 
            for ($i = 0; $i < count($subjects['network']); $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$subjects['network'][$i]?>">
                        <img src="<?= $rows[$subjects['network'][$i]]['img'] ?>" alt="<?= $rows[$subjects['network'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                        <span><strong><?= $rows[$subjects['network'][$i]]['name'] ?></strong></span>
                    </a>
                </div>
        <?php }}else if($_GET['gubun'] == 'cipher'){ 
            for ($i = 0; $i < count($subjects['cipher']); $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$subjects['cipher'][$i]?>">
                        <img src="<?= $rows[$subjects['cipher'][$i]]['img'] ?>" alt="<?= $rows[$subjects['cipher'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                        <span><strong><?= $rows[$subjects['cipher'][$i]]['name'] ?></strong></span>
                    </a>
                </div>
        <?php }}else if($_GET['gubun'] == 'programming'){ 
            for ($i = 0; $i < count($subjects['programming']); $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$subjects['programming'][$i]?>">
                        <img src="<?= $rows[$subjects['programming'][$i]]['img'] ?>" alt="<?= $rows[$subjects['programming'][$i]]['name'] ?>" style="width:220px; margin:20px;">
                        <span><strong><?= $rows[$subjects['programming'][$i]]['name'] ?></strong></span>
                    </a>
                </div>
        <?php }} ?>
        </div>
</body>
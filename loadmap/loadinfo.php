<?php
    session_start();
    include "../utils/common.php";
    
    $idx = isset($_GET['div']) ? $_GET['div'] : '';
    if($idx == ''){
        echo "<script>alert('정상적인 입력값이 아닙니다.');history.back(-1);</script>";
        exit;
    }


    $query = 'SELECT * FROM lecture WHERE idx = ?';
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param('i', $idx);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $grade = round($row['grade']);
    $star = str_repeat('⭐', $grade);
    $curriculum = explode(",", $row['curriculum']);
    $detailcurri = explode("@", $row['detailcurri']);
    $price = round($row['price'] / 6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../utils/main.css">
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
        .main-banner {
            margin-top: 10px;
            width: 100%;
            height: 300px;
            background-color: black;
            display: flex;
            flex-wrap: wrap; /* 추가: flex 컨테이너가 작아질 때 줄바꿈 허용 */
        }

        .text-container {
            width: 60%;
            height: 100%;
            padding: 80px;
            color: white;
            box-sizing: border-box; /* 추가: 패딩 포함 박스 크기 계산 */
        }

        .picture-container {
            width: 40%; /* 수정: width 0% -> 40%로 변경하여 사진 컨테이너 공간 확보 */
            height: 100%; /* 수정: height 50% -> 100%로 변경하여 사진 컨테이너 높이 설정 */
            padding: 30px;
            box-sizing: border-box; /* 추가: 패딩 포함 박스 크기 계산 */
        }

        .picture-container img {
            width: 100%;
            height: 100%;
        }
        .lecture-register-box {
            background-color: whitesmoke;
            height: 300px;
            width: 40%;
            border-radius: 10px;
            padding: 20px;
            margin-top: 0px;
            top: 400px; /* 화면 상단에서 100px 떨어진 위치에 고정 */
            right: 10%; /* 화면 오른쪽에서 10% 떨어진 위치에 고정 */
            z-index: 1000; /* 다른 요소들보다 위에 표시되도록 z-index 설정 */
            border : solid 1px gray;
        }
        .fixed {
            position: fixed;
            top: 0;
            right: 10%;
            z-index: 1000;
            width:32%;
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
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=sec">정보 보안</a></li>
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=game">게임 개발</a></li>
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=dbms">데이터베이스</a></li>
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=cs">컴퓨터 공학</a></li>
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=network">네트워크</a></li>
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=cipher">암호학</a></li>
                                <li><a class="dropdown-item" href="../gubun/index.php?gubun=programming">프로그래밍</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>커뮤니티</strong>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../community/qna.php">질문 & 답변</a></li>
                                <li><a class="dropdown-item" href="../community/review.php">수강평</a></li>
                                <li><a class="dropdown-item" href="../community/study.php">스터디</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../loadmap/index.php"><strong>로드맵</strong></a>
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
        <div class="main-banner">
            <div class="text-container">
                <h3><strong><?=$row['name']?></strong></h3>
                <h5><?=$star ,$row['grade']?></h5>
            </div>
            <div class="picture-container">
                <img src="<?=$row['img']?>" alt="">
            </div>
        </div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" data-target="target1">강의소개</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" data-target="target2">커리큘럼</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../community/qna.php" data-target="target4">수강전 문의</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <div style="width:100%; display:flex">
            <div style="width:60%; border:solid 1px gray;border-radius:5px">
                <div style="padding:20px;">
                    <?=$row['intro']?>
                </div>
                <div class="accordion" id="target2">
                    <?php for($i=0; $i<count($curriculum); $i++){ ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse100+<?=$i?>" aria-expanded="false" aria-controls="collapse100+<?=$i?>">
                        <?= $curriculum[$i] ?>
                        </button>
                        </h2>
                        <div id="collapse100+<?=$i?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <?php $detailCnt = explode(",", $detailcurri[$i]);
                        for ($j=0; $j<count($detailCnt); $j++){ ?>
                        <div class="accordion-body" style="height:5px; padding:10px;">
                            <p style="text-align: left;">⏯ <?=$detailCnt[$j]?></p>
                        </div>
                        <hr>
                        <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="lecture-register-box" style="text-align:center;" id="register">
                <h5><strong>월 <?=$price?>원 (6개월 할부시)</strong></h5>
                <h5><?=round($row['price'])?>원</h5>
                <p>수강 기한 : 무제한</p>
                <p>수료증 : 발급</p>
                <button type="button" class="btn btn-success" style="margin:auto; text-align:center; width:70%; height:20%">바로 수강신청 하기</button>
            </div>
        </div>
    </div>    
    <script>
            const register = document.querySelector('#register');
            document.querySelectorAll('.nav-link').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
            window.addEventListener('scroll', function() {
                const registerBox = document.querySelector('#register');
                if (window.scrollY >= 450) {
                    registerBox.classList.add('fixed');
                } else {
                    registerBox.classList.remove('fixed');
                }
            });
            window.addEventListener('scroll', function() {
                console.log(window.scrollY);
            });

    </script>
</body>
</html>
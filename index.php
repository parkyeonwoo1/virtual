<?php
    session_start();
    include "./utils/common.php";
    $query = "SELECT title, writer,idx,password FROM board limit 0, 5";
    $result = $db_conn->query($query);

    $lectures = array(
        0 => array(
            'title' => '[UNITY] 유니티로 입문하는 게임 프로그래밍',
            'image' => './images/1.png',
            'price' => 4.680,
        ),
        1 => array(
            'title' => '[악성코드] 인공지능을 이용한 악성코드 분석 및 탐지',
            'image' => './images/2.png',
            'price' => 4.810
        ),
        2 => array(
            'title' => '[iOS] iOS 프로그래밍 - 이론과 실습',
            'image' => './images/3.png',
            'price' => 4.260
        ),
        3 => array(
            'title' => '[정보보안] 사이버 시큐리티 - 웹해킹',
            'image' => './images/4.png',
            'price' => 4.730
        ),
        4 => array(
            'title' => 'HTML/CSS/JavaScript 한 번에 끝내기',
            'image' => './images/5.png',
            'price' => 4.720
        ),
        5 => array(
            'title' => '[System] 초심자를 위한 시스템 해킹',
            'image' => './images/6.png',
            'price' => 4.880
        ),
        6 => array(
            'title' => '[AI] 생성형 인공지능 & LLM 공격 및 분석',
            'image' => './images/7.png',
            'price' => 4.930
        ),
        7 => array(
            'title' => '코틀린을 통해 개발하는 안드로이드',
            'image' => './images/8.png',
            'price' => 4.620
        ),
        8 => array(
            'title' => 'S/W 엔지니어를 위한 로드맵',
            'image' => './images/9.png',
            'price' => 4.990
        ),
        9 => array(
            'title' => '클라우드 아키텍처의 A-Z',
            'image' => './images/10.png',
            'price' => 4.550
        ),
        10 => array(
            'title' => '데이터분석가를 위한 로드맵',
            'image' => './images/11.png',
            'price' => 4.190
        ),
        11 => array(
            'title' => '현대 운영체제의 이해',
            'image' => './images/12.png',
            'price' => 4.280
        )
    );
    $query = 'SELECT * FROM review';
    $result = $db_conn->query($query);
    $review = array();

    while ($row = $result->fetch_assoc()) {
        $review[] = $row;
    }
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
        .information-box-container {
            height: 50vh; 
            overflow-y: auto;
            position: relative;
            mask-image: linear-gradient(to bottom, black 60%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 60%, transparent 100%);
        }

        .information-box {
            padding: 20px; 
            text-align:left;
            border: solid gray 1px; 
            background-color: whitesmoke; 
            border-radius: 5px; 
            width: 500px; 
            margin-left: 20px;
            margin-bottom: 20px;
            overflow-wrap: break-word;
        }
        .information-box-container::-webkit-scrollbar {
            display: none;
        }
        .codelearn-box{
            margin-left:50px;
            width:35%;
            height: 16vh;
            text-align:left;
        }
        
    </style>
</head>
<body>
    <div style="width:80%; margin: auto; margin-top:20px">
        <!-- 부트스트랩 navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">
            <div class="container">
                <a class="navbar-brand" href="./index.php">CodeLearn</a>
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
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=sec">정보 보안</a></li>
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=game">게임 개발</a></li>
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=dbms">데이터베이스</a></li>
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=cs">컴퓨터 공학</a></li>
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=network">네트워크</a></li>
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=cipher">암호학</a></li>
                                <li><a class="dropdown-item" href="./gubun/index.php?gubun=programming">프로그래밍</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>커뮤니티</strong>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="./community/qna.php">질문 & 답변</a></li>
                                <li><a class="dropdown-item" href="./community/review.php">수강평</a></li>
                                <li><a class="dropdown-item" href="./community/study.php">스터디</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./loadmap/index.php"><strong>로드맵</strong></a>
                        </li>
                        <form class="d-flex" role="search" id="container" style="width:350px" action="./search/index.php">
                            <input name="keyword" class="form-control me-2" type="search" placeholder="나의 진짜 성장을 도와줄 실무 강의를 찾아보세요" aria-label="Search" style="border-radius:10px;" autocomplete="off">
                            <button type="submit">🔍</button>
                        </form>
                            <?php
                                if(!isset($_SESSION['login'])){

                            ?>
                            <li class="nav-item" style="flex:right">
                                <a class="nav-link" href="./login/login.php"><strong>로그인</strong></a>
                            </li>
                            <?php
                                }else{

                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./login/logout.php"><strong>로그아웃</strong></a>
                            </li>
                        <?php
                            }
                        ?>
                        <?php 
                            if(isset($_SESSION['id'])){
                                if($_SESSION['id'] == 'admin'){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./mypage/index.php">관리자님</a>
                        </li>
                        <?php
                                }else{
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./mypage/index.php"><?=$_SESSION['id']?>님</a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- 부트스트랩 navbar -->

        <!-- 캐러셀 박스 -->
        <div style="overflow: hidden; width: 100%; margin-top:10px; margin-bottom:0px">
            <div class="slide-container">
                <div class="slide-box">
                    <img src="./images/ban1.png" alt="">
                </div>         
                <div class="slide-box">
                    <img src="./images/ban2.png" alt="">
                </div>   
                <div class="slide-box">
                    <img src="./images/ban3.png" alt="">
                </div>
            </div>
        </div>
        <!-- 캐러셀 박스 -->


        <h4 style="text-align:center; margin:40px; margin-top:0px"><strong>배우고, 나누고, 성장하세요 !</strong></h4>
        <!-- 중간 화면에 배치할 검색란 -> 배우고 싶은 분야를 검색하면 AI가 자동으로 해당 주제에 맞는 강의를 추천해줌 -->
        <form id="container" action="ai/index.php">
            <input name="keyword" type="text" placeholder="배우고 싶은 분야를 검색해보세요" autocomplete="off" autofocus>
            <button type="submit">🔍</button>
        </form>
        <!-- 중간 화면에 배치할 검색란 -> 배우고 싶은 분야를 검색하면 AI가 자동으로 해당 주제에 맞는 강의를 추천해줌 -->
        
        <!-- 부트캠프, 보안, 스프링, 개발 등등 다양한 아이콘을 추가하여 클릭시 해당 강의목록으로 이동 -->
        <div id="lecture-img">
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=cipher">
                    <img src="./images/cipher.png" alt="암호학" style="width:50px; margin:20px;">
                    <span>#암호학</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=dbms">
                    <img src="./images/data.png" alt="데이터" style="width:50px; margin:20px;">
                    <span>#데이터</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=sec">
                    <img src="./images/security.png" alt="정보보안" style="width:50px; margin:20px;">
                    <span>#정보보안</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=cs">
                    <img src="./images/cloud.png" alt="컴퓨터공학" style="width:50px; margin:20px;">
                    <span>#컴퓨터공학</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=game">
                    <img src="./images/game.png" alt="게임" style="width:50px; margin:20px;">
                    <span>#게임개발</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=programming">
                    <img src="./images/python.png" alt="파이썬" style="width:50px; margin:20px;">
                    <span>#프로그래밍</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./gubun/index.php?gubun=network">
                    <img src="./images/network.png" alt="네트워크" style="width:50px; margin:20px;">
                    <span>#네트워크</span>
                </a>
            </div>
        </div>
        <!-- 부트캠프, 보안, 스프링, 개발 등등 다양한 아이콘을 추가하여 클릭시 해당 강의목록으로 이동 -->


        <!-- 내가 좋아할만한 다른 강의 목록 -->
        <h4 style="margin-top:20px"><strong>내가 좋아할만한 다른 강의</strong></h4>
        <div id="lecture-img">
            <?php for($i=0; $i<4; $i++){ ?>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture/index.php?div=<?=$i+1?>">
                    <img src="<?=$lectures[$i]['image']?>" alt="암호학" style="width:220px; margin:20px;">
                    <span><strong><?=$lectures[$i]['title']?></strong></span>
                </a>
                <p><strong>⭐ : <?=$lectures[$i]['price']?></strong></p>
            </div>
            <?php } ?>
        </div>
        <!-- 내가 좋아할만한 다른 강의 목록 -->

        <!-- 얼리버드 할인중인 신규 강의 목록 -->
        <h4 style="margin-top:20px"><strong>얼리버드 할인중인 신규 강의<span style="font-size:15px; color:red">NEW!!</span></strong></h4>
        <div id="lecture-img">
            <?php for($i=4; $i<8; $i++){ ?>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture/index.php?div=<?=$i+1?>">
                    <img src="<?=$lectures[$i]['image']?>" alt="암호학" style="width:220px; margin:20px;">
                    <span><strong><?=$lectures[$i]['title']?></strong></span>
                </a>
                <p><strong>⭐ : <?=$lectures[$i]['price']?></strong></p>
            </div>
            <?php } ?>
        </div>
        <!-- 얼리버드 할인중인 신규 강의 목록 -->
         
        <!-- 기본부터 실무까지 제시해주는 로드맵 -->
        <h4 style="margin-top:20px"><strong>기본부터 실무까지 제시해주는 로드맵<span style="font-size:15px; color:red">🏃🏻‍♀️ RoadMap!!</span></strong></h4>
        <div id="lecture-img">
            <div id="lecture-img">
                <?php for($i=8; $i<12; $i++){ ?>
                <div class="lecture-item" style="width:250px">
                    <a href="./lecture/index.php?div=<?=$i+1?>">
                        <img src="<?=$lectures[$i]['image']?>" alt="암호학" style="width:220px; margin:20px;">
                        <span><strong><?=$lectures[$i]['title']?></strong></span>
                    </a>
                    <p><strong>⭐ : <?=$lectures[$i]['price']?></strong></p>
                </div>
                <?php } ?>
            </div>
         <div>
        <!-- 기본부터 실무까지 제시해주는 로드맵 -->

            <div style="display: flex; width:120%">
                <div class="codelearn-box">
                    <h2><strong><span style="color:green">4,454,654</span>명이 코드런과 함께합니다.</strong></h2>
                    <p>코드런은 강의의 수강생수, 평점을 투명하게 공개합니다.<br>실제로 많은 온오프라인 학원들은 단기적 성과를 높이기 위해 잘나온 특정 후기만 노출 하거나,<br>아예 숨겨버리는 경우가 많습니다.반면 코드런은 강의에 대한 후기, 학생수 등 정보를 투명하게 공개합니다.<br>신뢰성을 바탕으로 학습자들이 더 좋은 컨텐츠를 선택하고 교육의 질을 높입니다.</p>
                </div>
                <div class="information-box-container">
                    <?php for ($i=0; $i<count($review); $i++) { ?>
                        <div class="information-box">
                            <p><strong><?= $review[$i]['username'] ?>님</strong></p>
                            <p><?= $review[$i]['content'] ?></p>
                        </div>
                    <?php } ?>
                </div>
            <div>
        </div>
        </div>
    </div>
    <script>
        const btn_history = document.querySelector('#history');
        const history_modal = document.querySelector('#history-show');
        document.addEventListener("DOMContentLoaded", function() {
            const slide_container = document.querySelector('.slide-container');
            let i = 0;
            function repeat() {
                setTimeout(() => {
                    slide_container.style.transform = `translateX(${-i * 80}vw)`;
                    i++;
                    if (i > 2) i = 0;
                    repeat(); 
                }, 2500);
            }
            repeat(); 
        });
    </script>
        <div class="footer">
        <p>&copy; 2024 CodeLearn. All rights reserved.</p>
    </div>
</body>
</html>

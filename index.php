<?php
    session_start();
    include "./utils/common.php";
    $query = "SELECT title, writer,idx,password FROM board limit 0, 5";
    $result = $db_conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACS Security</title>
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
                                <li><a class="dropdown-item" href="#">정보 보안</a></li>
                                <li><a class="dropdown-item" href="#">게임 개발</a></li>
                                <li><a class="dropdown-item" href="#">데이터베이스</a></li>
                                <li><a class="dropdown-item" href="#">클라우드</a></li>
                                <li><a class="dropdown-item" href="#">네트워크</a></li>
                                <li><a class="dropdown-item" href="#">암호학</a></li>
                                <li><a class="dropdown-item" href="#">프로그래밍</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
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
                            <a class="nav-link" href="./product.php"><strong>로드맵</strong></a>
                        </li>
                        <div id="container2">
                            <input id="mainsearch" type="text" placeholder="나의 진짜 성장을 도와줄 실무 강의를 찾아보세요">
                            <button>🔍</button>
                        </div>
                            <?php
                                if(!isset($_SESSION['login'])){

                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./login/user_login.php"><strong>로그인</strong></a>
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
                                if($_SESSION['id'] == 'CATCHMEIFYOUCAN'){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./mypage.php">관리자님</a>
                        </li>
                        <?php
                                }else{
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./mypage.php"><?=$_SESSION['id']?>님</a>
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
        <div style="overflow: hidden; width: 100%; margin-top:10px">
            <div class="slide-container">
                <div class="slide-box">
                    <img src="./image/ban1.png" alt="">
                </div>         
                <div class="slide-box">
                    <img src="./image/ban2.png" alt="">
                </div>   
                <div class="slide-box">
                    <img src="./image/ban3.png" alt="">
                </div>
            </div>
        </div>
        <!-- 캐러셀 박스 -->


        <h4 style="text-align:center; margin:40px">배우고, 나누고, 성장하세요 !</h4>
        <!-- 중간 화면에 배치할 검색란 -> 배우고 싶은 분야를 검색하면 AI가 자동으로 해당 주제에 맞는 강의를 추천해줌 -->
        <div id="container">
            <input type="text" placeholder="배우고 싶은 분야를 검색해보세요">
            <button>🔍</button>
        </div>
        <!-- 중간 화면에 배치할 검색란 -> 배우고 싶은 분야를 검색하면 AI가 자동으로 해당 주제에 맞는 강의를 추천해줌 -->
        
        <!-- 부트캠프, 보안, 스프링, 개발 등등 다양한 아이콘을 추가하여 클릭시 해당 강의목록으로 이동 -->
        <div id="lecture-img">
            <div class="lecture-item">
                <a href="./lecture?div=cipher">
                    <img src="./images/cipher.png" alt="암호학" style="width:50px; margin:20px;">
                    <span>#암호학</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./lecture?div=data">
                    <img src="./images/data.png" alt="데이터" style="width:50px; margin:20px;">
                    <span>#데이터</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./lecture?div=data">
                    <img src="./images/security.png" alt="정보보안" style="width:50px; margin:20px;">
                    <span>#정보보안</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./lecture?div=data">
                    <img src="./images/cloud.png" alt="클라우드" style="width:50px; margin:20px;">
                    <span>#클라우드</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./lecture?div=data">
                    <img src="./images/mobile.png" alt="모바일" style="width:50px; margin:20px;">
                    <span>#모바일</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./lecture?div=data">
                    <img src="./images/python.png" alt="파이썬" style="width:50px; margin:20px;">
                    <span>#파이썬</span>
                </a>
            </div>
            <div class="lecture-item">
                <a href="./lecture?div=data">
                    <img src="./images/network.png" alt="네트워크" style="width:50px; margin:20px;">
                    <span>#네트워크</span>
                </a>
            </div>
        </div>
        <!-- 부트캠프, 보안, 스프링, 개발 등등 다양한 아이콘을 추가하여 클릭시 해당 강의목록으로 이동 -->


        <!-- 내가 좋아할만한 다른 강의 목록 -->
        <h4 style="margin-top:20px"><strong>내가 좋아할만한 다른 강의</strong></h4>
        <div id="lecture-img">
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=cipher">
                    <img src="./images/linux.png" alt="암호학" style="width:200px; margin:20px;">
                    <span><strong>리눅스 시스템 프로그래밍</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/reversing.jpg" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>윈도우즈 리버싱</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/android.png" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>안드로이드 루팅</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/kernal.jpeg" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>리눅스 커널 해킹 A-Z까지</strong></span>
                </a>
            </div>
        </div>
        <!-- 내가 좋아할만한 다른 강의 목록 -->

        <!-- 얼리버드 할인중인 신규 강의 목록 -->
        <h4 style="margin-top:20px"><strong>얼리버드 할인중인 신규 강의<span style="font-size:15px; color:red">NEW!!</span></strong></h4>
        <div id="lecture-img">
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=cipher">
                    <img src="./images/test1.png" alt="암호학" style="width:200px; margin:20px;">
                    <span><strong>Java A-Z 정복</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/test2.jpg" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>Next JS로 SNS 개발</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/test3.jpg" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>파이썬으로 시작하는 데이터분석</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/test4.jpg" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>영상편집의 정점, 캠컷</strong></span>
                </a>
        </div>
        <!-- 얼리버드 할인중인 신규 강의 목록 -->
         
        <!-- 기본부터 실무까지 제시해주는 로드맵 -->
        <h4 style="margin-top:20px"><strong>내가 좋아할만한 다른 강의</strong></h4>
        <div id="lecture-img">
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=cipher">
                    <img src="./images/test.png" alt="암호학" style="width:200px; margin:20px;">
                    <span><strong>BoB 보안 컨설팅 트랙 합격 로드맵</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/java.png" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>정보보안 전문가 되기 - CS부터 시스템까지</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/coding.png" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>삼성전자 합격하는 코딩테스트</strong></span>
                </a>
            </div>
            <div class="lecture-item" style="width:250px">
                <a href="./lecture?div=data">
                    <img src="./images/full.png" alt="데이터" style="width:200px; margin:20px;">
                    <span><strong>풀스택 개발자 로드맵</strong></span>
                </a>
            </div>
        </div>
        <!-- 기본부터 실무까지 제시해주는 로드맵 -->
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
</body>
</html>

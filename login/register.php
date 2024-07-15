<?php
    session_start();
    include "../utils/common.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
        .regcontainer{
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
        <!-- 부트스트랩 navbar -->
        <div class="regcontainer">
            <div style="text-align:center">
                <h4><strong>회원 가입</strong></h4>
                <p>코드런에서 다양한 학습 기회를 얻으세요</p>
            </div>
            <div class="card-body">
                <form class="form-signin" action="./regAction.php" method="POST" ><br>
                    아이디
                    <input type="text" id="uid" class="form-control" placeholder="example" required autofocus name="uid" autocomplete="off" autofocus style="margin-bottom:15px;">
                    비밀번호
                    <input type="password" id="uid" class="form-control" placeholder="**********" required autofocus name="upw" autocomplete="off" style="margin-bottom:15px;">
                    비밀번호 확인
                    <input type="password" id="uid" class="form-control" placeholder="**********" required autofocus name="upw2" autocomplete="off" style="margin-bottom:15px;">
                        <div style="text-align:center">
                            <button id="btn_reg" class="btn btn-lg btn-primary btn-block" type="submit" style="background-color: #333; border: none;" onclick="location.href='regAction.php';">가입하기</button>
                        </div>
                </form>
            </div>
        </div>
    </div>    
</body>
</html>
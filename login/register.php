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
        .black-bg {
            width : 100%;
            height : 100%;
            position : fixed;
            background : rgba(0,0,0,0.5);
            z-index : 5;
            padding: 30px;  
            display: none;
        }
        .white-bg {
            background: white;
            border-radius: 5px;
            padding: 30px;
            width: 70%;
            margin: auto;
            margin-top: 5%;
            height: 85%;
        } 
        .show-modal{
            display: block;
        }        
        .parent {
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }
        .pro-box{
            width:80%;
            height:80%;
            overflow: auto;
            background-color : whitesmoke;
            margin:auto;
            border-radius: 15px;
        }
    </style>
</head>
<body>
        <!-- 삭제 수정 누르면 나오는 모달창 평소엔 안 보임 -->
    <div class="black-bg" style=" justify-content: center; align-items: center; height: 100vh;" id="modal">
        <div class="white-bg" style="text-align: center;">
            <h4 id="modal-content"></h4>
            <div class="pro-box">
                <p id="pro-content" style="padding : 10px;"></p>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 5%;">
                <button type="button" class="btn btn-outline-danger" style="margin-left: 10px;" id="modal-cancel">확인</button>
            </div>
        </div>
    </div>

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
                    <div style="font-size:10px">
                        <p><input type="checkbox" id="che1"><span id="pro1">이용약관에 동의합니다.(필수)</span></p>
                        <p><input type="checkbox" id="che2"><span id="pro2">위와 같이 본인의 개인정보를 수집·이용하는 것에 동의합니다.(필수)</span></p>
                    </div>
                        <div style="text-align:center">
                            <button id="btn_reg" class="btn btn-lg btn-primary btn-block" type="submit" style="background-color: #333; border: none;">가입하기</button>
                        </div>
                </form>
            </div>
        </div>
    </div>    
    <script>
        const modal = document.querySelector('#modal');
        const cancel = document.querySelector('#modal-cancel')
        const register = document.querySelector('#btn_reg');
        const pro1 = document.querySelector('#pro1')
        const pro2 = document.querySelector('#pro2')
        const pro3 = document.querySelector('#pro3')
        const content = document.querySelector('#modal-content')
        const box = document.querySelector('#pro-content');
        const che1 = document.querySelector('#che1');
        const che2 = document.querySelector('#che2');


        
        cancel.addEventListener('click', ()=>{
            modal.classList.remove('show-modal');
        })
        
        pro1.addEventListener('click', ()=>{
            modal.classList.add('show-modal');
            content.textContent = "약관동의";
            box.innerHTML = text1;
        })
        pro2.addEventListener('click', ()=>{
            modal.classList.add('show-modal');
            content.textContent = "개인정보 수집 이용 조회 동의";
            box.innerHTML = text2;
        })

        check();

        function check() {
            if (che1.checked && che2.checked) {
                register.disabled = false;
            } else {
                register.disabled = true;
            }
        }
        che1.addEventListener('change', check);
        che2.addEventListener('change', check);
        const text1 = `<strong>제1장 총칙</strong><br><br>
<br><br><strong>제1조(목적)</strong><br>
본 약관은 대·중소기업·농어업협력재단 기술보호통합포털(이하 "당 관리시스템")이 제공하는 모든 서비스(이하 "서비스")의 이용조건 및 절차, 이용자와 당 관리시스템의 권리, 의무, 책임사항과 기타 필요한 사항을 규정함을 목적으로 합니다.<br><br>
<strong>제2조(약관의 효력 및 변경)</strong><br>
① 당 관리시스템은 귀하가 본 약관 내용에 동의하는 것을 조건으로 귀하에게 서비스를 제공할 것이며, 귀하가 본 약관의 내용에 동의
    하는 경우, 당 관리시스템의 서비스 제공 행위 및 귀하의 서비스 사용 행위에는 본 약관이 우선적으로 적용될 것입니다.<br>

② 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 당 관리시스템의 초기화면에 그 적용일자 7일 이전부터
    적용일자 전일까지 공지합니다. 다만, 이용자에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을
    두고 공지합니다. 이 경우 당 관리시스템은 개정 전 내용과 개정 후 내용을 명확하게 비교하여 이용자가 알기 쉽도록 표시합니다.
    이용자가 변경된 약관에 동의하지 않는 경우, 이용자는 본인의 회원등록을 취소(회원탈퇴)할 수 있으며 계속 사용의 경우는 약관
    변경에 대한 동의로 간주됩니다.<br><br>

<strong>제3조(약관 외 준칙)</strong><br>
① 본 약관은 당 관리시스템이 제공하는 서비스에 관한 이용규정 및 별도 약관과 함께 적용됩니다.<br>
② 본 약관에 명시되지 않은 사항은 전기통신기본법, 전기통신사업법, 정보통신윤리위원회심의규정, 정보 통신 윤리강령, 컴퓨터 프로
    그램보호법 및 기타 관련 법령의 규정에 의합니다.<br><br>
<strong>제4조 (용어의 정의)</strong><br>
본 약관에서 사용하는 용어의 정의는 다음과 같습니다.<br>
① 이용자 : 본 약관에 따라 당 관리시스템이 제공하는 서비스를 받는 자<br>
② 가입 : 당 관리시스템이 제공하는 회원가입 양식에 해당 정보를 기입하고, 본 약관에 동의하여 서비스 이용 계약을 완료시키는 행위<br>
③ 회원 : 당 관리시스템에 개인 정보를 제공하여 회원 등록을 한 자로서, 당 관리시스템의 정보를 제공받으며, 당 관리시스템이 제공하
    는 서비스를 이용할 수 있는 자<br>
④ 비밀번호 : 이용자와 회원ID가 일치하는지를 확인하고 통신상의 자신의 비밀보호를 위하여 이용자 자신이 선정한 문자와 숫자의
    조합<br>
⑤ 탈퇴 : 회원이 이용계약을 종료시키는 행위<br>
⑥ 본 약관에서 정의하지 않은 용어는 개별서비스에 대한 별도 약관 및 이용규정에서 정의합니다<br><br>
<strong>제2장 서비스 제공 및 이용</strong>   <br><br>
<strong>제5조(이용계약의 성립)</strong><br>
① 이용계약은 신청자가 온라인으로 당 관리시스템에서 제공하는 소정의 회원가입 신청양식에서 요구하는 사항을 기록하여 가입을 완
    료하는 것으로 성립됩니다.<br>
② 당 관리시스템은 다음 각 호에 해당하는 이용계약에 대하여는 가입을 취소할 수 있습니다.<br>
- 다른 사람의 명의를 사용하여 신청하였을 때<br>
- 이용 계약 신청서의 내용을 허위로 기재하였거나 신청하였을 때<br>
- 사회의 안녕 질서 혹은 미풍양속을 저해할 목적으로 신청하였을 때<br>
- 다른 사람의 당 관리시스템 서비스 이용을 방해하거나 그 정보를 도용하는 등의 행위를 하였을 때<br>
- 당 관리시스템을 이용하여 법령과 본 약관이 금지하는 행위를 하는 경우<br>
- 기타 당 관리시스템이 정한 이용신청요건이 미비 되었을 때<br>
③ 당 관리시스템은 다음 각 항에 해당하는 경우 그 사유가 해소될 때까지 이용계약 성립을 유보할 수 있습니다.<br>
- 서비스 관련 제반 용량이 부족한 경우<br>
- 기술상 장애 사유가 있는 경우<br>
④ 당 관리시스템이 제공하는 서비스는 아래와 같으며, 그 변경될 서비스의 내용을 이용자에게 공지하고 아래에서 정한 서비스를 변경
    하여 제공할 수 있습니다.<br>
- E-mail을 통한 대·중소기업·농어업협력재단의 각종 정보 제공<br>
- 당 관리시스템이 자체 개발하거나 다른 기관과의 협의 등을 통해 제공하는 일체의 서비스<br><br>
<strong>제6조(회원정보사용에대한동의)</strong><br>
① 회원의 개인정보에 대해서는 당 관리시스템의 개인정보 보호정책이 적용됩니다.<br>
② 당 관리시스템의 회원 정보는 다음과 같이 수집, 사용, 관리, 보호됩니다.<br>
- 개인정보의 수집 : 당 관리시스템은 귀하의 당 관리시스템 서비스 가입시 귀하가 제공하는 정보를 통하여 귀하에 관한 정보를 수
   집하며 탈퇴시 수집된 모든 개인정보는 삭제됩니다. 다만, 당 관리시스템(이전 시스템 포함)을 통해 정부지원사업을 참여한
   이력이 있는 경우 각 지원사업의 관련법령이 정하는 바에 따라 일부 정보는 과제정보로서 보관되어 질 수 있습니다.<br>
- 개인정보의 사용 : 당 관리시스템은 당 관리시스템 서비스 제공과 관련해서 수집된 회원의 신상정보를 본인의 승낙 없이 제3자에
   게 누설, 배포하지 않습니다. 단, 전기통신기본법 등 법률의 규정에 의해 국가기관의 요구가 있는 경우, 범죄에 대한 수사상의
   목적이 있거나 정보통신윤리위원회의 요청이 있는 경우 또는 기타 관계법령에서 정한 절차에 따른 요청이 있는 경우,
   귀하가 당 관리시스템에 제공한 개인정보를 스스로 공개한 경우에는 그러하지 않습니다.<br>
- 개인정보의 관리 : 귀하는 개인정보의 보호 및 관리를 위하여 서비스의 개인정보관리에서 수시로 귀하의 개인정보를 수정/삭제할
   수 있습니다. 수신되는 정보 중 불필요하다고 생각되는 부분도 변경/조정할 수 있습니다.<br>
- 개인정보의 보호 : 귀하의 개인정보는 오직 귀하만이 열람/수정/삭제 할 수 있으며, 이는 전적으로 귀하의 ID와 비밀번호에 의해
   관리되고 있습니다. 따라서 타인에게 본인의 ID와 비밀번호를 알려주어서는 아니되며, 작업 종료시에는 반드시 로그아웃 해주
   시고, 웹 브라우저의 창을 닫아주시기 바랍니다. (이는 타인과 컴퓨터를 공유하는 인터넷 카페나 도서관 같은 공공장소에서
   컴퓨터를 사용하는 경우에 귀하의 정보의 보호를 위하여 필요한 사항입니다)<br>
③ 회원이 당 관리시스템에 본 약관에 따라 이용신청을 하는 것은 이용신청이 적용되는 기간동안 당 관리시스템이 본 약관에 따라 신청
    서에 기재된 회원정보를 수집, 이용하는 것에 동의하는 것으로 간주됩니다.<br><br>
<strong>제7조(정보보안)</strong><br>
① 가입 신청자가 당 관리시스템 서비스 가입 절차를 완료하는 순간부터 귀하는 입력한 정보의 비밀을 유지할 책임이 있으며, 회원의
    ID와 비밀번호를 사용하여 발생하는 모든 결과에 대한 책임은 회원본인에게 있습니다.<br>
② ID와 비밀번호에 관한 모든 관리의 책임은 회원에게 있으며, 회원의 ID나 비밀번호가 부정하게 사용 되었다는 사실을 발견한 경우에
    는 즉시 당 관리시스템에 신고하여야 합니다. 신고를 하지 않음으로 인한 모든 책임은 회원 본인에게 있습니다.<br>
③ 이용자는 당 관리시스템 서비스의 사용 종료시 마다 정확히 접속을 종료하도록 해야 하며, 정확히 종료하지 아니함으로써 제3자가
    귀하에 관한 정보를 이용하게 되는 등의 결과로 인해 발생하는 손해 및 손실에 대하여 당 관리시스템은 책임을 부담하지
    아니합니다.<br>
④ 관리시스템은 쿠키를 활용하여 개인정보를 수집하지 아니하며 인터넷 접속파일 등 개인정보를 자동으로 설치하는 장치를 거부하며
    관련된 장치를 운영하지 않습니다.<br>
⑤ 당 관리시스템은 수집·활용 중인 개인정보가 누출되고 그 사실을 인지시 개인정보 항목 및 발생시점 경위를 사용자에게 통보한다.<br><br>
<strong>제8조(서비스이용시간)</strong><br>
① 서비스 이용시간은 당 관리시스템의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴, 1일 24시간을 원칙으로 합니다.<br>
② 제1항의 이용시간은 정기점검 등의 필요로 인하여 당 관리시스템이 정한 날 또는 시간은 예외로 합니다.<br><br>
<strong>제9조(서비스의중지및정보의저장과사용)</strong><br>
① 귀하는 당 관리시스템 서비스에 보관되거나 전송된 메시지 및 기타 통신 메시지 등의 내용이 국가의 비상사태, 정전, 당 관리시스템
    의 관리 범위 외의 서비스 설비 장애 및 기타 불가항력에 의하여 보관되지 못하였거나 삭제된 경우, 전송되지 못한 경우 및 기타
    통신 데이터의 손실이 있을 경우에 당 관리시스템은 관련 책임을 지지 아니합니다.<br>
② 당 관리시스템이 정상적인 서비스 제공의 어려움으로 인하여 일시적으로 서비스를 중지하여야 할 경우에는 서비스 중지 1주일 전의
    고지 후 서비스를 중지할 수 있으며, 이 기간 동안 귀하가 고지내용을 인지하지 못한 데 대하여 당 관리시스템은 책임을 부담하지
    아니합니다.부득이한 사정이 있을 경우 위 사전 고지기간은 감축되거나 생략될 수 있습니다. 또한 위 서비스 중지에 의하여 본
    서비스에 보관되거나 전송된 메시지 및 기타 통신 메시지 등의 내용이 보관되지 못하였거나 삭제된 경우, 전송되지 못한 경우 및
    기타 통신 데이터의 손실이 있을 경우에 대하여도 당 관리시스템은 책임을 부담하지 아니합니다.<br>
③ 당 관리시스템의 사정으로 서비스를 영구적으로 중단하여야 할 경우 제 2 항에 의거합니다. 다만, 이 경우 사전 고지기간은 1개월로
    합니다.<br>
④ 당 관리시스템은 사전 고지 후 서비스를 일시적으로 수정, 변경 및 중단할 수 있으며, 이에 대하여 귀하 또는 제3자에게 어떠한 책임
    도 부담하지 아니합니다.<br>
⑤ 당 관리시스템은 이용자가 본 약관의 내용에 위배되는 행동을 한 경우, 임의로 서비스 사용을 제한 및 중지 할 수 있습니다. 이 경우
    당 관리시스템은 위 이용자의 접속을 금지할 수 있습니다.<br><br>
<strong>제10조(서비스의변경및해지)</strong><br>
당 관리시스템은 귀하가 서비스를 이용하여 기대하는 손익이나 서비스를 통하여 얻은 자료로 인한 손해에 관하여 책임을 지지 않으며, 회원이 본 서비스에 게재한 정보, 자료, 사실의 신뢰도, 정확성 등 내용에 관하여는 책임을 지지 않습니다.<br>`

        const text2 = `대·중소기업·농어업협력재단(이하 “재단” 이라 한다)은 「개인정보보호법」 제15조 제1항 제1호, 제17조 제1항 제1호, 제23조 제1호 따라 아래와 같이 개인정보의 수집. 이용에 관하여 귀하의 동의를 얻고자 합니다.<br><br>

재단은 이용자의 사전 동의 없이는 이용자의 개인정보를 함부로 공개하지 않으며, 수집된 정보는 아래와 같이 이용하고 있습니다.<br>
이용자가 제공한 모든 정보는 아래의 목적에 필요한 용도 이외로는 사용되지 않으며 이용 목적이 변경될 시에는 이를 알리고 동의를 구할 것입니다.<br>
<br>
<br>
<strong>개인정보의 수집 및 이용 동의</strong><br>
<strong>1. 개인정보의 수집 및 이용 목적</strong><br>
가. 회원 관리<br>
- 회원제 서비스 이용 및 제한적 본인 확인제에 따른 본인확인, 개인식별, 가입의사 확인, 가입 및 가입횟수 제한, 추후 법정 대리인 본인확인, 분쟁 조정을    위한 기록보존, 불만처리 등 민원처리, 공지사항 전달 등을 목적으로 개인정보를 처리합니다.<br>
나. 정부지원사업 신청 및 선정기업(학교) 관계자 관리<br>
- "중소기업기술 보호 지원에 관한 법률" 등 법령에 근거하여 시행하는 정부지원사업 행정규칙(법령, 요령, 지침 등) 내용에 따라 신청(지원)기업의 대표자,    참여자 등의 관리, 신청·선정·협약 등에 필요한 자격(의무사항 불이행, 참여제한, 참여율 등)여부 확인, 보고·사후관리·통계 등의 목적으로 개인정보를
   처리합니다.<br>
다. 정부지원사업 평가위원, 전문가 등의 관리<br>
- 정부지원사업(법령, 요령, 지침 등)에서 정한 평가위원·전문가 등의 자격확인, 평가참여이력 등의 행정업무를 목적으로 개인정보를 처리합니다.<br>
라. 민원사무 처리<br>
- 민원인의 신원 확인, 민원사항 확인, 사실조사를 위한 연락·통지, 처리결과 통보 등을 목적으로 개인정보를 처리합니다.<br>
마. 기술보호지원 서비스 제공<br>
- 콘텐츠 제공, 특정 맞춤 서비스 제공, 서비스 유지보수 및 기능개선, 본인인증 등을 목적으로 개인정보를 처리합니다.<br>
바. 홍보 등의 활용<br>
- 신규 또는 매년 공고되는 정부지원사업의 안내, 정부지원사업 참여자에 대한 의무사항, 성과조사 등의 안내, 정책적 참조를 위한 설문조사 요청, 접속빈도
   파악 또는 회원의 서비스 이용에 대한 통계, 이벤트 및 홍보성 정보 제공 등을 목적으로 개인정보를 처리합니다.<br>
<br>
<strong>2. 수집하는 개인정보의 항목</strong><br>
가. 일반회원 가입<br>
① 필수항목<br>
- 성명, 아이디, 비밀번호, 일반전화번호, 휴대전화번호, 이메일, 자택주소, 뉴스레터 수신여부<br>
② 선택항목<br>
- 팩스번호, 직장사업자번호, 직장명, 부서, 직위, 회사주소<br>
나. 전문가회원 가입<br>
① 필수항목<br>
- 개인정보 : 성명, 아이디, 이메일, 소속기관, 부서, 직위, 일반전화번호, 휴대전화번호, 직장주소<br>
- 학력사항 : 출신학교, 전공, 학위, 입학일자, 증명서류 , 근무처, 근무부서, 직급, 입사일자, 업무내용, 증명서류<br>
② 선택항목<br>
- 개인정보 : 스번호, 은행명, 계좌번호, 자택주소<br>
- 학력사항 : 지도교수명, 졸업일자, 논문명<br>
- 경력사항 : 퇴사일자<br>
- 연구논문 : 연구제목, 발행년월, 게재처, 번호, 주저자명, 공동저자, 책임저자, SCI논문여부, ISBN, 증명서류<br>
- 자격증 및 포상 : 취득년도, 자격(포상)명, 자격번호, 포상등급, 발행기관, 증명서류<br>
- 학회 및 협회활동 : 학회명, 직위, 시작일, 종료일, 담당업무, 증명서류<br>
- 정부출연과제수행실적 : 시행부처명, 시행년도, 사업명, 과제명, 시작일, 종료일, 정부출연금, 참여역할, 평가결과, 출연기관명<br>
- 지식재산권 : 특허형태, 특허명, 출원번호, 출원일자, 출원자명, 발명자명, 특허공개번호, 공개일자, 등록번호, 등록일자, 소속기관, 등록국가, PCT출원<br>
   여부, 사업화여부, 증명서류<br>
다. 자동수집<br>
IP 주소, 쿠키, 서비스 이용 기록, 방문기록 등<br>
<br>
<strong>3. 개인정보의 보유 및 이용기간</strong><br>
재단은 원칙적으로 보유기간의 경과, 개인정보의 수집 및 이용목적의 달성 등 그 개인정보가 불필요하게 되었을 때에는 지체 없이 파기합니다.<br>
다만, 다른 법령에 따라 보존하여야 하는 경우에는 그러하지 않을 수 있습니다. 불필요하게 되었을 때에는 지체 없이 해당 개인정보를 파기합니다.<br>
<br>
<strong>4. 동의 거부권 및 불이익</strong><br>
정보주체는 개인정보 수집에 동의를 거부할 권리가 있습니다. 다만, 필수 항목에 대한 동의를 거부할 시 저희가 제공하는 서비스를 이용할 수 없습니다.<br>
<br>
<strong>5. 14세 미만 아동의 경우 회원가입 및 저희가 제공하는 서비스를 이용할 수 없습니다.</strong><br>`
    </script>
</body>
</html>
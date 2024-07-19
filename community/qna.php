<?php
session_start();
include "../utils/common.php";
include "./board/lib.php"; 
$results = []; // 검색 결과를 저장할 배열 초기화

// 기본 정렬 기준 설정
$default_sort_column = 'idx';
$default_sort = 'DESC';

// 사용자 입력의 유효성 검사 및 SQL Injection 방지
$allowed_columns = ['idx', 'title', 'writer', 'regdate']; // 허용되는 열 목록
$sort_column = isset($_GET['sort_column']) && in_array($_GET['sort_column'], $allowed_columns) ? $_GET['sort_column'] : $default_sort_column;
$sort = isset($_GET['sort']) && in_array(strtoupper($_GET['sort']), ['ASC', 'DESC']) ? strtoupper($_GET['sort']) : $default_sort;

$limit = 5;
$page_limit = 5;
$page = isset($_GET['page']) && preg_match("/^[0-9]*$/", $_GET['page']) ? $_GET['page'] : 1;

$start_page = ($page - 1) * $limit;

// 전체 게시물 수 조회
$query = "SELECT count(*) as cnt FROM board";
$stmt = $db_conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['cnt'];

if (isset($_POST['search_type'])) {
    // 검색 유형과 검색어 가져오기
    $search_type = $_POST['search_type'];
    $keyword = "%" . $_POST['keyword'] . "%";

    // SQL 쿼리 및 바인딩 변수 설정
    switch ($search_type) {
        case 'all':
            $query = "SELECT * FROM board WHERE title LIKE ? OR writer LIKE ? OR content LIKE ? LIMIT ?, ?";
            $stmt = $db_conn->prepare($query);
            $stmt->bind_param('sssii', $keyword, $keyword, $keyword, $start_page, $limit);
            break;
        case 'title':
            $query = "SELECT * FROM board WHERE title LIKE ? LIMIT ?, ?";
            $stmt = $db_conn->prepare($query);
            $stmt->bind_param('sii', $keyword, $start_page, $limit);
            break;
        case 'writer':
            $query = "SELECT * FROM board WHERE writer LIKE ? LIMIT ?, ?";
            $stmt = $db_conn->prepare($query);
            $stmt->bind_param('sii', $keyword, $start_page, $limit);
            break;
        case 'content':
            $query = "SELECT * FROM board WHERE content LIKE ? LIMIT ?, ?";
            $stmt = $db_conn->prepare($query);
            $stmt->bind_param('sii', $keyword, $start_page, $limit);
            break;
        default:
            echo "검색 유형을 확인할 수 없습니다.";
            exit();
    }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        $num = count($results);
} else {
    // 기본 SQL 쿼리 실행
    $query = "SELECT * FROM board ORDER BY $sort_column $sort LIMIT ?, ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param('ii', $start_page, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $num = count($results);
}
$adminCnt = 0;
$userCnt = 0;
for($i=0; $i<count($results); $i++){
    if($results[$i]['writer'] == 'admin'){
        $adminCnt += 1;
    }else{
        $userCnt += 1;
    }
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
                                <li><a class="dropdown-item" href="./qna.php">질문 & 답변</a></li>
                                <li><a class="dropdown-item" href="./review.php">수강평</a></li>
                                <li><a class="dropdown-item" href="./study.php">스터디</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../loadmap/index.php"><strong>로드맵</strong></a>
                        </li>
                        <form class="d-flex" role="search" id="container" style="width:350px" action="../search/index.php">
                            <input autocomplete="off" name="keyword" class="form-control me-2" type="search" placeholder="나의 진짜 성장을 도와줄 실무 강의를 찾아보세요" aria-label="Search" style="border-radius:10px; ">
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
                            <a class="nav-link" href="../mypage/index.php"><?=$_SESSION['login']?>님</a>
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
        <div style="width: 80%; margin: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%; text-align:center"><a href="./qna.php?sort_column=idx&sort=asc" style="text-decoration: none; color: black">Index ▼</a></th>
                        <th scope="col" style="width: 50%"><a href="./qna.php?sort_column=title&sort=asc" style="text-decoration: none; color: black">Title ▼</a></th>
                        <th scope="col" style="width: 20%"><a href="./qna.php?sort_column=writer&sort=asc" style="text-decoration: none; color: black">Writer ▼</a></th>
                        <th scope="col" style="width: 20%"><a href="./qna.php?sort_column=regdate&sort=asc" style="text-decoration: none; color: black">Date ▼</a></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    // 조건문을 통해서 password가 관리자 패스워드와 일치하면 공지게시글로 전환
                    if($num != 0){
                        for($i=0; $i<count($results); $i++){
                            if($results[$i]['writer'] == 'admin'){ ?>
                    <tr>
                        <th style="text-align: center;">[공지]</th>
                        <th><a href="./board/view.php?idx=<?=$results[$i]['idx']?>" style="color: black; text-decoration: none"><?=$results[$i]['title']?></a></th>
                        <th>관리자</th>
                        <th><?=date('Y-m-d', strtotime($results[$i]["regdate"]))?></th>
                    </tr>
                    <?php }else{ ?>
                    <tr>
                        <td style="text-align: center"><?=$results[$i]["idx"]?></td>
                        <td><a href="./board/view.php?idx=<?=$results[$i]["idx"]?>" style="color: black; text-decoration: none"><?=$results[$i]["title"]?></a></td>
                        <td><?=$results[$i]["writer"]?></td>
                        <td><?=date('Y-m-d', strtotime($results[$i]["regdate"]))?></td>
                    </tr>
                    <?php }}}else { ?>
                    <tr>
                        <td colspan="4">Posts does not exist.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <form id="searchForm" method="post" action="./qna.php">
                <div class="input-group mb-3">
                    <div class="col-auto my-1" style="margin-right: 10px">
                        <select name="search_type" id="inlineFormCustomSelect" class="form-select form-select-sm" aria-label="Small select example">
                            <option value="all" selected>All</option>
                            <option value="title">Title</option>
                            <option value="writer">Writer</option>
                            <option value="content">Content</option>
                        </select>
                    </div>
                    <input type="text" class="form-control" placeholder="Keyword Input" name="keyword" id="search_input" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <?php
                $show_keyword = isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : '';
                if ($show_keyword !=''){
            ?>
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
                <strong>"<?=$show_keyword?>"에 대한 검색 결과입니다.</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                }
            ?>
            <div style="display: flex; justify-content: space-between;">
                <?php
                    $rs_str = my_pagination($total, $limit, $page_limit, $page);
                    echo $rs_str;
                ?>
                <button type="button" class="btn btn-outline-success" onclick="redirectToWritePage()" style="height:40px">Write</button>
            </div>
        </div>    
        <script>
            function redirectToWritePage() {
                window.location.href = "./board/write.php";
            }
        </script>
</body>
</html>
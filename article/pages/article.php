<?php
require_once("../../db_connect.php");

// 每頁顯示的數量
$per_page = 10;

// 初始化篩選條件
$whereClause = "WHERE article.is_deleted = 0"; // 加入基礎條件

// 搜尋條件
if (isset($_GET["search"])) {
  $search = $conn->real_escape_string($_GET["search"]);
  $whereClause .= " AND (category.name LIKE '%$search%' 
                          OR article.title LIKE '%$search%' 
                          OR article.author LIKE '%$search%' 
                          OR article.created_at LIKE '%$search%' )";
}

// 類別篩選條件
if (isset($_GET["category"])) {
  $category_id = intval($_GET["category"]); // 確保類別是整數
  $whereClause .= " AND article.category_id = $category_id";
}

// 計算總筆數（根據篩選條件）
$sql_count = "SELECT COUNT(*) AS total 
              FROM article 
              JOIN category ON article.category_id = category.id 
              $whereClause";

$count_result = $conn->query($sql_count);
$row_count = $count_result->fetch_assoc();
$article_count = $row_count["total"]; // 符合條件的總筆數

// 計算總頁數
$total_page = ceil($article_count / $per_page);

// 分頁與排序
$p = isset($_GET["p"]) ? intval($_GET["p"]) : 1;
$order = isset($_GET["order"]) ? intval($_GET["order"]) : 1;
$start_item = ($p - 1) * $per_page;

// 主查詢（應用篩選條件）
$sql = "SELECT article.*, category.name 
        FROM article 
        JOIN category ON article.category_id = category.id 
        $whereClause";

// 排序條件
switch ($order) {
  case 1:
    $sql .= " ORDER BY article.id ASC";
    break;
  case 2:
    $sql .= " ORDER BY article.created_at DESC";
    break;
  case 3:
    $sql .= " ORDER BY article.created_at ASC";
    break;
}

$base_url = "article_list.php?";
if (isset($_GET["search"])) {
  $base_url .= "search=" . urlencode($_GET["search"]) . "&";
}
if (isset($_GET["category"])) {
  $base_url .= "category=" . intval($_GET["category"]) . "&";
}
if (isset($_GET["p"])) {
  $base_url .= "p=" . intval($_GET["p"]) . "&";
}

// 分頁限制
$sql .= " LIMIT $start_item, $per_page";

// 執行主查詢
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// 載入類別篩選
$cateSql = "SELECT * FROM category";
$resultCate = $conn->query($cateSql);
$categories = $resultCate->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>
    Material Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include("../../sidebar.php") ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">文章列表</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <form action="" method="get">
              <div class="input-group input-group-outline">
                <label class="form-label"></label>
                <input type="search" class="form-control" name="search" value="<?= $_GET["search"] ?? "" ?>" required>
              </div>
            </form>
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
              </a>
            </li>
            <li class="nav-item dropdown pe-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-symbols-rounded">notifications</i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
                <i class="material-symbols-rounded">account_circle</i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                <div>
                  <h4 class="text-white ps-3">文章列表</h4>
                  <h6 class="text-secondary ps-3">共計<?= $article_count ?>筆文章</h6>
                </div>
                <div><a href="create-article.php"><button class="btn btn-dark btn-outline-light text-white me-3">新增文章<i class="fa-solid fa-plus"></i></button></a></div>
              </div>
            </div>



            <div class="card-body p-5">
              <div class="">
                <div class="ms-3">
                  <ul class="nav nav-underline mb-3">
                    <li class="nav-item">
                      <a class="nav-link text-dark-emphasis <?php if (!isset($_GET["category"])) echo "active" ?>" aria-current="page" href="article.php">全部</a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                      <li class="nav-item">
                        <a href="article.php?category=<?= $category["id"] ?>" class="nav-link text-dark-emphasis <?php if (isset($_GET["category"]) && $_GET["category"] == $category["id"]) echo "active" ?>"><?= $category["name"] ?></a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="d-flex justify-content-between">
                  <div>
                    <?php if (isset($_GET["search"])): ?>
                      <a class="btn btn-light" href="article.php"><i class="fa-solid fa-circle-left fa-lg"></i></a>
                    <?php endif; ?>
                  </div>
                  <div class="btn-group">
                    <?php
                    $base_url = "article.php?";
                    if (isset($_GET["search"])) {
                      $base_url .= "search=" . urlencode($_GET["search"]) . "&";
                    }
                    if (isset($_GET["category"])) {
                      $base_url .= "category=" . intval($_GET["category"]) . "&";
                    }
                    $base_url .= "p=" . intval($p) . "&";
                    ?>
                    <a class="btn btn-light" href="<?= $base_url ?>order=1">
                      ID <i class="fa-solid fa-arrow-down"></i>
                    </a>
                    <a class="btn btn-light" href="<?= $base_url ?>order=2">最新</a>
                    <a class="btn btn-light" href="<?= $base_url ?>order=3">最舊</a>
                  </div>
                </div>

                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bolder opacity-7 ps-2">標題</th>
                      <th class="font-weight-bolder opacity-7 ps-2">作者</th>
                      <th class="font-weight-bolder opacity-7 ps-2">發布日期</th>
                      <th class="font-weight-bolder opacity-7 ps-2">類別</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($rows as $row): ?>
                      <tr>
                        <td><?= $row["title"] ?></td>
                        <td><?= $row["author"] ?></td>
                        <td><?= $row["created_at"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><a href="preview-article.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-eye fa-fw pe-4"></i></a><a href="edit-article.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>


              </div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <?php
            // 如果 p 參數沒有設定，則預設為第 1 頁
            $currentPage = isset($_GET["p"]) ? $_GET["p"] : 1;
            $order = isset($_GET["order"]) ? $_GET["order"] : 1; // 預設排序方式為 1
            ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <?php for ($i = 1; $i <= $total_page; $i++): ?>
                  <li class="page-item <?php if ($i == $currentPage) echo "active"; ?>">
                    <a
                      class="page-link 
              <?php if ($i == $currentPage) {
                    echo 'bg-dark text-white';
                  } else {
                    echo 'bg-white text-dark';
                  } ?>"
                      style="border-color: transparent;"
                      href="article.php?p=<?= $i ?>&order=<?= $order ?>">
                      <?= $i ?>
                    </a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("location: sign-in.php");
  exit();
}
require_once("../../db_connect.php");

$per_page = 10; // 每頁顯示的項目數量

$sqlAll = "SELECT * FROM users WHERE is_deleted=0";
$resultAll = $conn->query($sqlAll);
$userAllCount = $resultAll->num_rows;


//搜尋姓名、email、電話、帳號
if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $sql = "SELECT * FROM users WHERE(name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR account LIKE '%$search%') AND is_deleted=0";
} else if (isset($_GET["p"])) {
  $p = $_GET["p"];
  if (!isset($_GET["order"])) {
    header("location: users.php?p=1&order=1");
  }

  // 構建查詢語句
  $whereClause = "WHERE is_deleted=0";
  $search = '';
  if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $whereClause .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR account LIKE '%$search%')";
  }

  //點擊表頭排序
  $p = $_GET['p'] ?? 1;
  $order = $_GET['order'] ?? 'id';
  $direction = $_GET['direction'] ?? 'asc';
  $new_direction = ($direction == 'asc') ? 'desc' : 'asc';

  switch ($order) {
    case 'name':
      $order_by = "LENGTH(name)";
      break;
    case 'account':
      $order_by = "account";
      break;
    case 'email':
      $order_by = "email";
      break;
    case 'phone':
      $order_by = "phone";
      break;
    default:
      $order_by = "id";
  }

  $sql = "SELECT * FROM users $whereClause ORDER BY $order_by $direction LIMIT " . (($p - 1) * $per_page) . ", $per_page";
  $result = $conn->query($sql);

  $sql_count = "SELECT COUNT(*) as count FROM users $whereClause";
  $result_count = $conn->query($sql_count);
  $user_count = $result_count->fetch_assoc()['count'];

  $sql = "SELECT users.*, user_level.level_name FROM users 
          JOIN user_level ON users.user_level_id = user_level.id 
          WHERE users.is_deleted = 0 
          ORDER BY $order_by $direction 
          LIMIT " . (($p - 1) * 10) . ", 10";

  $result = $conn->query($sql);
  $rows = $result->fetch_all(MYSQLI_ASSOC);

  $user_count_sql = "SELECT COUNT(*) as count FROM users WHERE is_deleted = 0";
  $user_count_result = $conn->query($user_count_sql);
  $user_count = $user_count_result->fetch_assoc()['count'];

  // 頁碼
  $order = $_GET["order"];
  $start_item = ($p - 1) * $per_page;
  $total_page = ceil($userAllCount / $per_page);

  // 下面是舊的icon排序
  // $whereClause = "";
  // switch ($order) {
  //   case 1:
  //     $whereClause = "ORDER BY id ASC";
  //     break;
  //   case 2:
  //     $whereClause = "ORDER BY id DESC";
  //     break;
  //   case 3:
  //     $whereClause = "ORDER BY account ASC";
  //     break;
  //   case 4:
  //     $whereClause = "ORDER BY account DESC";
  //     break;
  //   case 5:
  //     $whereClause = "ORDER BY email ASC";
  //     break;
  //   case 6:
  //     $whereClause = "ORDER BY email DESC";
  //     break;
  //   case 7:
  //     $whereClause = "ORDER BY phone ASC";
  //     break;
  //   case 8:
  //     $whereClause = "ORDER BY phone DESC";
  //     break;
  // }

  // $sql = "SELECT * FROM users WHERE is_deleted=0 
  //         $whereClause
  //         LIMIT $start_item, $per_page";
} else {
  header("location: users.php?p=1&order=1");
}


$result = $conn->query($sql);
if (isset($_GET["search"])) {
  $user_count = $result->num_rows;
} else {
  $user_count = $userAllCount;
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <!-- 網頁tilte記得改!!!! -->
  <title>
    會員管理
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .no-background {
      background: none;
      border: none;
      padding: 0;
    }

    .table tbody tr:nth-child(odd) {
      background-color: #f2f2f2;
    }
  </style>
</head>

<!-- Side Bar -->

<body class="g-sidenav-show  bg-gray-100">
  <?php include_once("../../sidebar.php") ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <!-- Breadcrumb 字體大小請用text-lg -->
            <li class="breadcrumb-item text-lg text-dark active" aria-current="page">會員管理</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <form action="" method="get">
                <div class="input-group">
                  <label class="form-label"></label>
                  <input type="text" class="form-control" name="search" value="<?= $_GET["search"] ?? "" ?>" placeholder="請輸入關鍵字">
                  <button type="submit" style="border:none;" class="no-background ms-2"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                </div>
              </form>
            </div>
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="users.php" class="nav-link text-body font-weight-bold px-0">
                <i class="material-symbols-rounded">account_circle</i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-1">
      <div class="py-2">
        <?php if (isset($_GET["search"])): ?>
          <a class="btn btn-dark me-2" href="users.php"><i class="fa-solid fa-left-long fa-fw"></i></a>
        <?php endif; ?>


        <!-- <div class="d-flex justify-content-end align-items-center">
          舊的icon排序
        <?php if (isset($_GET["p"])): ?>
          <div>
            <?php
            $order = $_GET["order"] ?? "";
            ?>
            <div class="btn-group me-3">
              <a class="btn bg-gradient-dark <?php if ($order == 1) echo "active" ?>" href="users.php?p=<?= $p ?>&order=1"><i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
              <a class="btn bg-gradient-dark <?php if ($order == 2) echo "active" ?>" href="users.php?p=<?= $p ?>&order=2"><i class="fa-solid fa-arrow-down-9-1 fa-fw"></i></a>
              <a class="btn bg-gradient-dark <?php if ($order == 2) echo "active" ?>" href="users.php?p=<?= $p ?>&order=3"><i class="fa-solid fa-arrow-down-a-z fa-fw"></i></a>
              <a class="btn bg-gradient-dark <?php if ($order == 2) echo "active" ?>" href="users.php?p=<?= $p ?>&order=4"><i class="fa-solid fa-arrow-down-z-a fa-fw"></i></a>
            </div>
          </div>
        <?php endif; ?>
      </div> -->

      </div>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <!-- 黑色card的padding 請用 pt-3 pb-2 -->
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <div class="d-flex justify-content-between align-items-center">
                  <!-- 黑色card title 字體粗細請用 fw-normal 字體大小fs-5 -->
                  <span class="text-white fw-normal fs-5 ps-4">會員列表</span>
                  <!-- 新增按鈕請包在黑色card裡面 -->
                  <a class="btn btn-outline-light text-white btn-sm mb-0 me-3" target="_blank" href="user-add.php">新增會員</a>
                </div>
                <!-- 共計...請包在黑色card裡面 字體粗細請用 fw-normal  字體大小 fs-6  -->
                <div class="text-secondary fw-normal fs-6 ps-4 mt-1 mb-2">
                  共計 <?= $user_count ?> 位使用者
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <?php if ($result->num_rows > 0): ?>
                  <table class="table justify-content-between align-items-center mb-0">
                    <thead>
                      <tr>
                        <?php
                        $order = $_GET['order'] ?? 'id';
                        $direction = $_GET['direction'] ?? 'asc';
                        $new_direction = ($direction == 'asc') ? 'desc' : 'asc';
                        ?>
                        <th class="text-secondary text-center text-sm fw-bold opacity-7">
                          <a href="users.php?p=<?= $p ?>&order=id&direction=<?= $new_direction ?>" class="text-secondary">User ID
                            <?php if ($order == 'id'): ?>
                              <i class="fa-solid fa-arrow-<?= $direction == 'asc' ? 'down' : 'up' ?>"></i>
                            <?php endif; ?></a>
                        </th>
                        <th class="text-secondary text-sm fw-bold opacity-7 ps-3">
                          <a href="users.php?p=<?= $p ?>&order=account&direction=<?= $new_direction ?>" class="text-secondary">帳號
                            <?php if ($order == 'account'): ?>
                              <i class="fa-solid fa-arrow-<?= $direction == 'asc' ? 'down' : 'up' ?>"></i>
                            <?php endif; ?></a>
                          </a>
                        </th>
                        <th class="text-secondary text-sm fw-bold opacity-7 ps-3">
                          <a href="users.php?p=<?= $p ?>&order=name&direction=<?= $new_direction ?>" class="text-secondary">姓名
                            <?php if ($order == 'name'): ?>
                              <i class="fa-solid fa-arrow-<?= $direction == 'asc' ? 'down' : 'up' ?>"></i>
                            <?php endif; ?></a>
                          </a>
                        </th>
                        <th class="text-center text-sm fw-bold opacity-7 ps-2">
                          <a href="users.php?p=<?= $p ?>&order=email&direction=<?= $new_direction ?>" class="text-secondary">Email
                            <?php if ($order == 'email'): ?>
                              <i class="fa-solid fa-arrow-<?= $direction == 'asc' ? 'down' : 'up' ?>"></i>
                            <?php endif; ?></a>
                          </a>
                        </th>
                        <th class="text-center text-sm fw-bold opacity-7 ps-2">
                          <a href="users.php?p=<?= $p ?>&order=phone&direction=<?= $new_direction ?>" class="text-secondary">電話
                            <?php if ($order == 'phone'): ?>
                              <i class="fa-solid fa-arrow-<?= $direction == 'asc' ? 'down' : 'up' ?>"></i>
                            <?php endif; ?></a>
                          </a>
                        </th>
                        <th class="text-secondary opacity-7"></th>
                        <th class="text-secondary opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($rows as $user): ?>
                        <tr class="mt-3">
                          <td class="text-center w-10 py-3"><?= $user["id"] ?></td>
                          <td><a href="user.php?id=<?= $user["id"] ?>"><?= $user["account"] ?></a></td>
                          <td><?= $user["name"] ?></td>
                          <td class="text-center"><?= $user["email"] ?></td>
                          <td class="text-center"><?= $user["phone"] ?></td>
                          <td>
                            <!-- 查看及編輯功能請用icon不要用文字 -->
                            <a class="text-secondary text-sm fw-bold opacity-7" href="user.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye fa-fw pe-4"></i></a>
                          </td>
                          <td>
                            <a class="text-secondary text-sm fw-bold opacity-7" href="user-edit.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
        <?php if (isset($_GET["p"])): ?>
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center ms-3 mt-3">
              <!--指定active頁碼為黑底白字，其餘為白底黑字。a標籤暫時用style="border-color: transparent;"蓋過原生css粉色外框 -->
              <?php for ($i = 1; $i <= $total_page; $i++): ?>
                <li class="page-item ms-2 <?php if ($i == $_GET["p"]) echo "active"; ?>">
                  <a style="border-color: transparent;" class="page-link 
                  <?php if ($i == $_GET["p"]) echo 'bg-gradient-dark text-white';
                      else echo 'bg-white text-dark'; ?>" href="users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?>
                  </a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      <?php else: ?>
        <div class="ms-4 my-2">未找到相關使用者</div>
      <?php endif; ?>
      </div>

      <!--   Core JS Files   -->
      <script src="../assets/js/core/popper.min.js"></script>
      <script src="../assets/js/core/bootstrap.min.js"></script>
      <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
      <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
      <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
      </script>
      <!-- Github buttons -->
      <script async defer src="https://buttons.github.io/buttons.js"></script>
      <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
      <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
<?php
// session_start();
// if (!isset($_SESSION["user_id"])) {
//   header("location: sign-in.php");
//   exit();
// }
require_once("../../db_connect.php");

$sql = "SELECT * FROM coupons WHERE is_deleted=0";
$result = $conn->query($sql);
$results = $result->fetch_all(MYSQLI_ASSOC);
$couponAllCount = $result->num_rows;

$per_page = 5; // 每頁顯示的項目數量

// 構建查詢語句
$whereClause = "WHERE is_deleted=0";
$search = '';
if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $whereClause .= " AND (name LIKE '%$search%' OR type LIKE '%$search%' OR discount_type LIKE '%$search%' OR discount LIKE '%$search%')";
}else if (!isset($_GET["p"])) {
  $p =1;
  if (!isset($_GET["order"])) {
    header("Location: coupons.php?p=1&order=1");
  }
}

$p = $_GET['p'] ?? 1;
$order = $_GET['order'] ?? 'id';
$direction = $_GET['direction'] ?? 'asc';
$new_direction = ($direction == 'asc') ? 'desc' : 'asc';

switch ($order) {
  case 'name':
    $order_by = "name";
    break;
  case 'type':
    $order_by = "type";
    break;
  case 'discount_type':
    $order_by = "discount_type";
    break;
  case 'discount':
    $order_by = "discount";
    break;
  default:
    $order_by = "id";
}

$sql = "SELECT * FROM coupons $whereClause ORDER BY $order_by $direction LIMIT " . (($p - 1) * $per_page) . ", $per_page";
$result = $conn->query($sql);
$results = $result->fetch_all(MYSQLI_ASSOC);

$sql_count = "SELECT COUNT(*) as count FROM coupons $whereClause";
$result_count = $conn->query($sql_count);
$coupon_count = $result_count->fetch_assoc()['count'];

$start_item = ($p - 1) * $per_page;
$total_page = ceil($couponAllCount / $per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    優惠券管理
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">

    <?php include("../../sidebar.php") ?>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
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
    <div class="container-fluid py-2">
      <div class="py-2">
        <?php if (isset($_GET["search"])): ?>
          <a class="btn btn-dark me-2" href="coupons.php"><i class="fa-solid fa-left-long fa-fw"></i></a>
        <?php endif; ?>

        <?php if (isset($_GET["p"])): ?>
          <?php
          $order = $_GET["order"] ?? "";
          ?>
        <?php endif; ?>

      </div>
      <div class="row">

        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <div class="d-flex justify-content-between align-items-center">
                  <!-- 黑色card title 字體粗細請用 fw-normal 字體大小fs-5 -->
                  <span class="text-white fw-normal fs-5 ps-4">優惠券列表</span>
                  <!-- 新增按鈕請包在黑色card裡面 -->
                  <a class="btn btn-outline-light text-white btn-sm mb-0 me-3"  href="coupons-create.php">新增優惠券</a>
                </div>
                <!-- 共計...請包在黑色card裡面 字體粗細請用 fw-normal  字體大小 fs-6  -->
                <div class="text-secondary fw-normal fs-6 ps-4 mt-1 mb-2">
                  共計 <?= $coupon_count ?> 張優惠券
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <?php if ($result->num_rows > 0): ?>
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <?php
                        $order = $_GET['order'] ?? 'id';
                        $direction = $_GET['direction'] ?? 'asc';
                        $new_direction = ($direction == 'asc') ? 'desc' : 'asc';
                        ?>
                        <th class="text-secondary text-center text-sm fw-bold opacity-7">
                          <a href="coupons.php?p=<?= $p ?>&order=id&direction=<?= $new_direction ?>" class="text-secondary">Name</a>
                        </th>
                        <th class="text-secondary text-center text-sm fw-bold opacity-7">
                          <a href="coupons.php?p=<?= $p ?>&order=id&direction=<?= $new_direction ?>" class="text-secondary">Type</a>
                        </th>
                        <th class="text-secondary text-center text-sm fw-bold opacity-7">
                          <a href="coupons.php?p=<?= $p ?>&order=id&direction=<?= $new_direction ?>" class="text-secondary">Discount</a>
                        </th>
                        <th class="text-secondary text-center text-sm fw-bold opacity-7">
                          <a href="coupons.php?p=<?= $p ?>&order=id&direction=<?= $new_direction ?>" class="text-secondary">Start</a>
                        </th>
                        <th class="text-secondary text-center text-sm fw-bold opacity-7">
                          <a href="coupons.php?p=<?= $p ?>&order=id&direction=<?= $new_direction ?>" class="text-secondary">End</a>
                        </th>

                        <th class="text-secondary opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($results as $row): ?>
                        <tr class="mt-3">
                          <td class="text-center w-10 py-3">
                            <h6 class="mb-0 text-md"><?= $row["name"] ?></h6>
                          </td>

                          <td class="text-center w-10 py-3">
                            <p class="text-md font-weight-bold mb-0"><?= $row["type"] ?></p>
                          </td>

                          <td class="text-center w-10 py-3">
                            <p class="text-md font-weight-bold mb-0"><?= $row["discount"] ?></p>
                          </td>

                          <td class="align-middle text-center text-lg">
                            <span class="badge badge-sm bg-gradient-success"><?= $row["str_time"] ?></span>
                          </td>

                          <td class="align-middle text-center text-lg">
                            <span class="badge badge-sm bg-gradient-danger"><?= $row["end_time"] ?></span>
                          </td>

                          <td class="align-middle">
                            <a href="coupons-edit.php?id=<?= $row["id"] ?>" class="text-secondary font-weight-bold text-md badge " data-toggle="tooltip" data-original-title="Edit user"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
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
            <ul class="pagination justify-content-center ms-1 mt-3 me-5">
              <!--指定active頁碼為黑底白字，其餘為白底黑字。a標籤暫時用style="border-color: transparent;"蓋過原生css粉色外框 -->
              <?php for ($i = 1; $i <= $total_page; $i++): ?>
                <li class=" page-item ms-2  <?php if ($i == $_GET["p"]) echo "active"; ?>">
                  <a style="border-color: transparent;" class="page-link 
                  <?php if ($i == $_GET["p"]) echo 'bg-gradient-dark text-white';
                      else echo 'bg-white text-dark'; ?>" href="coupons.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?>
                  </a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      <?php else: ?>
        <div class="ms-4 my-2">未找到優惠券</div>
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
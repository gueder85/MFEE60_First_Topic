<?php
require_once("../../db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入 id 到此頁";
  exit;
}

$id = $_GET["id"];

// 使用 JOIN 來獲取城市名稱級會員名稱
$sql = "SELECT users.*, cities.city_name, user_level.level_name FROM users 
        JOIN cities ON users.city = cities.city_id 
        JOIN user_level ON users.user_level_id = user_level.id 
        WHERE users.id='$id' AND users.is_deleted=0";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
  echo "找不到使用者";
  exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    用戶資訊
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
  <style>
    .form-control {
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
    }

    .form-control:focus {
      border: 1px solid #bfd2e6;
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    #member_id {
      border: none;
      background-color: transparent;
      box-shadow: none;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include_once("sidebar.php") ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header pb-0 ms-3">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <h6 class="text-white fw-normal ps-4">用戶資料</h6>
              </div>
            </div>
            <div>
              <form action="user.php?id=<?= $id ?>" method="post">
                <div class="card-body">
                  <div class="row ms-3 mb-3">
                    <div class="col-lg-5 col-md-6">
                      <div class="my-3">
                        <label class="form-label fs-6 d-block">使用者圖片</label>
                        <?php if (!empty($row["profile_image"])): ?>
                          <img src="<?= $row["profile_image"] ?>" alt="Profile Image" class="img-thumbnail mt-2 d-block w-75">
                        <?php else: ?>
                            <img src="../images/icon.jpg" alt="Profile Image" class="img-thumbnail mt-2 d-block w-75">
                        <?php endif; ?>
                        <div class="mt-4">
                          <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-secondary mt-2">編輯</a>
                          <a href="users.php" class="btn btn-secondary mt-2 ms-3">返回</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                      <div class="my-3 custom-margin-left">
                        <label class="form-label">帳號</label>
                        <p class="form-control-plaintext ms-1"><?= $row["account"] ?></p>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">姓名</label>
                        <p class="form-control-plaintext ms-1"><?= $row["name"] ?></p>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">電子郵件</label>
                        <p class="form-control-plaintext ms-1"><?= $row["email"] ?></p>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">電話號碼</label>
                        <p class="form-control-plaintext ms-1"><?= $row["phone"] ?></p>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">城市</label>
                        <p class="form-control-plaintext ms-1"><?= $row["city_name"] ?></p>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">會員等級</label>
                        <p class="form-control-plaintext ms-1"><?= $row["level_name"] ?></p>
                      </div>

                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
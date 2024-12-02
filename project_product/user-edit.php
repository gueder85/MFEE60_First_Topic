<?php
require_once("./db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入 id 到此頁";
  exit;
}

$id = $_GET["id"];

// 檢查表單是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $user_level_id = $_POST["user_level_id"];
  $city = $_POST["city"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];

  // 更新使用者資料
  $sql = "UPDATE users SET name='$name', user_level_id='$user_level_id', city='$city', email='$email', phone='$phone' WHERE id=$id";
  if ($conn->query($sql) === TRUE) {
    echo "更新成功";
    // 重定向到使用者列表頁面
    header("Location: users.php");
    exit;
  } else {
    echo "更新失敗: " . $conn->error;
  }
} else {
  // 獲取使用者資料
  $sql = "SELECT * FROM users WHERE id='$id' AND is_deleted=0";
  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    echo "找不到使用者";
    exit;
  }

  $row = $result->fetch_assoc();
}

// 獲取所有會員等級
$sql = "SELECT * FROM user_level";
$result = $conn->query($sql);
$user_levels = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM cities";
$result = $conn->query($sql);
$cities = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    修改會員資料
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
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="...">
        <span class="ms-1 fw-light">會員管理</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/dashboard.html">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="../pages/tables.html">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">會員管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">登入</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-up.html">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">註冊</span>
          </a>
        </li>
      </ul>
    </div>
    <!-- Add your sidebar content here -->
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <h6 class="text-white fw-normal ps-4">修改會員資料</h6>
              </div>
            </div>
            <div class="card-body">
              <form action="user-edit.php?id=<?= $id ?>" method="post">
                <div class="mb-3">
                  <label for="member_id" class="form-label" id="member_id">會員編號</label>
                  <div class="ms-2"><?= $row["id"] ?></div>
                </div>
                <div class="mb-3 w-25">
                  <label for="name" class="form-label">帳號</label>
                  <div class="ms-2"><?= $row["account"] ?></div>
                </div>
                <div class="mb-3 w-25">
                  <label for="name" class="form-label">姓名</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?= $row["name"] ?>">
                </div>

                <div class="form-group w-25">
                  <label for="user_level_id">會員等級</label>
                  <select class="form-control" id="user_level_id" name="user_level_id" required>
                    <?php foreach ($user_levels as $level): ?>
                      <option value="<?= $level['level_id'] ?>" <?= $row['user_level_id'] == $level['level_id'] ? 'selected' : '' ?>><?= $level['level_name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-3 w-25">
                  <label for="email" class="form-label">電子郵件</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= $row["email"] ?>" required>
                </div>
                <div class="mb-3 w-25">
                  <label for="phone" class="form-label">電話號碼</label>
                  <input type="text" class="form-control" id="phone" name="phone" value="<?= $row["phone"] ?>" required>
                </div>
                <div class="form-group mb-3 w-25">
                  <label for="city">城市</label>
                  <select class="form-control" id="city" name="city" required>
                    <?php foreach ($cities as $city): ?>
                      <option value="<?= $city['city_id'] ?>" <?= $row['city'] == $city['city_id'] ? 'selected' : '' ?>><?= $city['city_name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div>
                  <button type="submit" class="btn btn-primary mt-5">儲存</button>
                  <a class="text-white" href="users.php?id=<?= $row["id"] ?>"></a>
                  <button type="submit" class="btn btn-primary mt-5 ms-2"><a class="text-white"
                      href="users.php">取消</a></button>
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
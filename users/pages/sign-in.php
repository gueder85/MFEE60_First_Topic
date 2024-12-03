<?php
session_start();

// 設定最大錯誤次數
$max_attempts = 3;

// 初始化錯誤次數
if (!isset($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = 0;
}

// 處理登入請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 假設這裡有一個函數來驗證使用者憑證
  if (validate_credentials($username, $password)) {
    // 登入成功，重置錯誤次數
    $_SESSION['login_attempts'] = 0;
    header("Location: dashboard.php");
    exit;
  } else {
    // 登入失敗，增加錯誤次數
    $_SESSION['login_attempts'] += 1;
  }
}

// 驗證使用者憑證的函數（僅作為範例）
function validate_credentials($username, $password)
{
  // 這裡應該有實際的驗證邏輯，例如查詢資料庫
  return $username === 'admin' && $password === 'password';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    六弦學院 Sign in
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

</head>

<body class="bg-gray-200">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-3 shadow position-absolute my-3 py-2 mx-4 w-20">
          <div class="container-fluid ps-2 pe-0">
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link me-2" href="sign-up.php">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    註冊
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="sign-in.php">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    登入
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>

  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100"
      style="background-image: url(../images/wallpaperflare.com_wallpaper.jpg); background-size: contain;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                  <h4 class="text-white fw-normal text-center mt-2 mb-0"> 登入</h4>
                </div>
              </div>
              <div class="card-body">
                <?php if (isset($_GET["error"])): ?>
                  <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                  </div>
                  <script>
                    // 清除 URL 中的查詢參數
                    if (typeof window.history.replaceState === 'function') {
                      window.history.replaceState({}, document.title, window.location.pathname);
                    }
                  </script>
                <?php endif; ?>
                <form action="doSignIn.php" role="form" class="text-start" method="post">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label"></label>
                    <input type="text" class="form-control" placeholder="帳號" name="account">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label"></label>
                    <input type="password" class="form-control" placeholder="密碼" name="password">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">記住我</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">登入</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    沒有帳號?
                    <a href="./sign-up.php" class="text-primary text-gradient font-weight-bold">註冊</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
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
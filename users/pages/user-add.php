<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新增資料</title>
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
  <!-- Custom CSS -->
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
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
      border: 1px solid #80bdff;
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* 下拉選單箭頭樣式 */
    .custom-select {
      position: relative;
      display: inline-block;
      width: 100%;
    }

    .custom-select select {
      display: inline-block;
      width: 100%;
      padding: 0.375rem 1.75rem 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      color: #495057;
      vertical-align: middle;
      background: #fff url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="4" height="5" viewBox="0 0 4 5"><path fill="%23333" d="M2 0L0 2h4L2 0zM2 5L0 3h4L2 5z"/></svg>') no-repeat right 0.75rem center;
      background-size: 8px 10px;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      appearance: none;
    }

    .custom-select select:focus {
      border: 1px solid #80bdff;
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
            <div class="card-header pb-0">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <h6 class="text-white fw-normal ps-4">新增資料</h6>
                <?php if (isset($error_message)): ?>
                  <div class="alert alert-danger" role="alert">
                    <?= $error_message ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-body">
              <form action="doCreateUser.php" method="POST" onsubmit="return validateForm()">
                <div class="mb-3 w-25">
                  <label for="name" class="form-label">姓名</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3 w-25">
                  <label for="account" class="form-label">帳號</label>
                  <input type="account" class="form-control" id="account" name="account" required>
                </div>
                <div class="mb-3 w-25">
                  <label for="account" class="form-label">密碼</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 w-25">
                  <label for="confirm_password" class="form-label">請再輸入密碼</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                  <div id="password_error" class="text-danger mt-2" style="display: none;">兩次輸入的密碼不一致</div>
                </div>
                <div class="mb-3 w-25">
                  <label for="gender" class="form-label">性別</label>
                  <select class="form-control" id="gender" name="gender" required>
                    <option value="">請選擇</option>
                    <option value="F">男</option>
                    <option value="M">女</option>
                  </select>
                </div>
                <div class="mb-3 w-25">
                  <label for="email" class="form-label">電子郵件</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3 w-25">
                  <label for="phone" class="form-label">電話號碼</label>
                  <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3 w-25">
                  <label for="city" class="form-label">居住城市</label>
                  <select class="form-control" id="city" name="city" required>
                    <option value="">請選擇</option>
                    <option value="1">台北市</option>
                    <option value="2">新北市</option>
                    <option value="3">桃園市</option>
                    <option value="4">台中市</option>
                    <option value="5">台南市</option>
                    <option value="6">高雄市</option>
                    <option value="7">基隆市</option>
                    <option value="8">新竹市</option>
                    <option value="9">嘉義市</option>
                    <option value="10">新竹縣</option>
                    <option value="11">苗栗縣</option>
                    <option value="12">彰化縣</option>
                    <option value="13">南投縣</option>
                    <option value="14">雲林縣</option>
                    <option value="15">嘉義縣</option>
                    <option value="16">屏東縣</option>
                    <option value="17">宜蘭縣</option>
                    <option value="18">花蓮縣</option>
                    <option value="19">台東縣</option>
                    <option value="20">澎湖縣</option>
                    <option value="21">金門縣</option>
                    <option value="22">連江縣</option>
                  </select>
                </div>
                <div class="form-group mb-3 w-25">
                  <label for="user_level_id">會員等級</label>
                  <select class="form-control" id="user_level_id" name="user_level_id" required>
                    <option value="1" selected>初學者</option>
                    <option value="2">愛好者</option>
                    <option value="3">進階玩家</option>
                    <option value="4">專業玩家</option>
                    <option value="5">吉他大師</option>
                  </select>
                  <button type="submit" class="btn btn-dark mt-4">新增會員</button>
                  <a href="users.php" class="btn btn-secondary mt-4">取消</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    function validateForm() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirm_password").value;
      var passwordError = document.getElementById("password_error");

      if (password !== confirmPassword) {
        passwordError.style.display = "block";
        return false;
      } else {
        passwordError.style.display = "none";
      }
      return true;
    }
  </script>

</body>

</html>
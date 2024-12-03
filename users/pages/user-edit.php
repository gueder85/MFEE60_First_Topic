<?php
require_once("../../db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入 id 到此頁";
  exit;
}

$id = $_GET["id"];
$showModal = false; // 用於控制顯示圖片更換成功的 Modal
$showSuccessModal = isset($_GET['save_success']);  // 控制顯示儲存成功的 Modal
$showDeleteSuccessModal = isset($_GET['delete_success']); // 控制顯示刪除成功的 Modal

// 獲取使用者資料的函數
function getUserData($conn, $id)
{
  $sql = "SELECT users.*, cities.city_name, user_level.level_name FROM users 
          JOIN cities ON users.city = cities.city_id 
          JOIN user_level ON users.user_level_id = user_level.id 
          WHERE users.id='$id' AND users.is_deleted=0";

  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    // echo "找不到使用者";
    header("Location: users.php");
    exit;
  }

  return $result->fetch_assoc();
}

// 檢查表單是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["confirm_delete"])) {
    // 刪除使用者
    $id = $_POST["id"];
    $sql = "UPDATE users SET is_deleted=1 WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
      header("Location: user-edit.php?id=$id&delete_success=1");
      exit;
    } else {
      echo "刪除失敗: " . $conn->error;
    }
  } else {
    // 檢查是否有文件上傳
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
      // 處理文件上傳
      $target_dir = "../uploads/";
      $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      // 檢查文件類型
      $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
      if ($check !== false) {
        // 檢查文件大小
        if ($_FILES["profile_image"]["size"] <= 500000) {
          // 允許的文件類型
          $allowed_types = ["jpg", "jpeg", "png", "gif"];
          if (in_array($imageFileType, $allowed_types)) {
            // 移動上傳的文件
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
              // 更新資料庫中的圖片路徑
              $sql = "UPDATE users SET profile_image='$target_file' WHERE id='$id'";
              if ($conn->query($sql) === TRUE) {
                $showModal = true; // 設置顯示 Modal 的標誌
              } else {
                echo "圖片上傳失敗: " . $conn->error;
              }
            } else {
              echo "文件移動失敗";
            }
          } else {
            echo "不允許的文件類型";
          }
        } else {
          echo "文件太大";
        }
      } else {
        echo "文件不是圖片";
      }
    }

    // 更新使用者資料
    $name = $_POST["name"];
    $user_level_id = $_POST["user_level_id"];
    $city = $_POST["city"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $sql = "UPDATE users SET name='$name', user_level_id='$user_level_id', city='$city', email='$email', phone='$phone' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
      header("Location: user-edit.php?id=$id&save_success=1");
      exit;
    } else {
      echo "更新失敗: " . $conn->error;
    }

    // 重新獲取使用者資料
    $row = getUserData($conn, $id);
  }
} else {
  // 獲取使用者資料
  $row = getUserData($conn, $id);
}

// 獲取所有會員等級
$sql = "SELECT * FROM user_level";
$result = $conn->query($sql);
$user_levels = $result->fetch_all(MYSQLI_ASSOC);

// 獲取所有城市
$sql = "SELECT * FROM cities";
$result = $conn->query($sql);
$cities = $result->fetch_all(MYSQLI_ASSOC);
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
  <?php include_once("../../sidebar.php") ?>

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
              <!-- <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog model-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      確認刪除該帳號
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">取消</button>
                      <a class="btn btn-dark text-white" href="userDoDelete.php?id=<?= $row["id"] ?>">確認</a>
                    </div>
                  </div>
                </div>
              </div> -->
              <form action="user-edit.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-5 col-md-6 mb-3">
                    <label for="profile_image" class="form-label d-block mt-2 mb-3">使用者圖片</label>
                    <?php if (!empty($row["profile_image"])): ?>
                      <img id="profile_image_preview" src="<?= $row["profile_image"] ?>" alt="Profile Image" class="img-thumbnail mt-2 d-block w-75">
                    <?php else: ?>
                      <!-- 預設圖片 -->
                      <img id="profile_image_preview" class="img-thumbnail mt-2 w-75 d-block" src="../images/icon.jpg">
                    <?php endif; ?>
                    <button type="button" class="btn btn-light text-dark mt-4" id="change_image_button" onclick="showImageInput()">變更使用者圖片</button>
                    <input type="file" class="form-control my-2 w-75" id="profile_image_input" name="profile_image" onchange="previewImage(event)" style="display: none;">
                    <div class="d-flex">
                      <button type="submit" class="btn btn-dark mt-4">儲存</button>
                      <a class="text-white" href="users.php?id=<?= $row["id"] ?>"></a>
                      <button type="button" class="btn btn-secondary mt-4 ms-2"><a class="text-white" href="users.php">取消</a></button>
                      <button type="button" class="btn btn-danger mt-4 ms-7" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">刪除</button>
                    </div>
                  </div>
                  <div class="col-lg-7 col-md-6">
                    <div class="mb-3">
                      <label for="member_id" class="form-label" id="member_id">會員編號</label>
                      <div class="ms-2"><?= $row["id"] ?></div>
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">帳號</label>
                      <div class="ms-2"><?= $row["account"] ?></div>
                    </div>
                    <div class="mb-3 w-50">
                      <label for="name" class="form-label">姓名</label>
                      <input type="text" class="form-control" id="name" name="name" value="<?= $row["name"] ?>">
                    </div>
                    <div class="form-group w-50">
                      <label for="user_level_id">會員等級</label>
                      <select class="form-control" id="user_level_id" name="user_level_id" required>
                        <?php foreach ($user_levels as $level): ?>
                          <option value="<?= $level['id'] ?>" <?= $row['user_level_id'] == $level['id'] ? 'selected' : '' ?>><?= $level['level_name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3 w-50">
                      <label for="email" class="form-label">電子郵件</label>
                      <input type="email" class="form-control" id="email" name="email" value="<?= $row["email"] ?>" required>
                    </div>
                    <div class="mb-3 w-50">
                      <label for="phone" class="form-label">電話號碼</label>
                      <input type="text" class="form-control" id="phone" name="phone" value="<?= $row["phone"] ?>" required>
                    </div>
                    <div class="form-group mb-3 w-50">
                      <label for="city">城市</label>
                      <select class="form-control" id="city" name="city" required>
                        <?php foreach ($cities as $city): ?>
                          <option value="<?= $city['city_id'] ?>" <?= $row['city'] == $city['city_id'] ? 'selected' : '' ?>><?= $city['city_name'] ?></option>
                        <?php endforeach; ?>
                      </select>
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


  <!-- 儲存成功 Modal -->
  <?php if ($showSuccessModal): ?>
    <div class="modal fade" id="saveSuccessModal" tabindex="-1" aria-labelledby="saveSuccessModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="saveSuccessModalLabel">儲存成功</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            使用者資料已成功儲存！
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">確定</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- 刪除前詢問 Modal -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">確認刪除</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          請確認是否刪除此使用者？
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
          <form method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="is_deleted" value="1">
            <button type="submit" name="confirm_delete" class="btn btn-danger">刪除</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- 刪除成功 Modal -->
  <!-- <?php if ($showDeleteSuccessModal): ?>
    <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteSuccessModalLabel">刪除成功</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            使用者已成功刪除！
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="redirectToUsers()">確定</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?> -->


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script>
    function showImageInput() {
      document.getElementById('profile_image_input').style.display = 'block';
      document.getElementById('change_image_button').style.display = 'none';
    }

    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('profile_image_preview');
        output.src = reader.result;
        output.style.display = 'block';
      };
      reader.readAsDataURL(event.target.files[0]);
    }

    <?php if ($showSuccessModal): ?>
      var saveSuccessModal = new bootstrap.Modal(document.getElementById('saveSuccessModal'));
      saveSuccessModal.show();
    <?php endif; ?>

    <?php if ($showDeleteSuccessModal): ?>
      var deleteSuccessModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
      deleteSuccessModal.show();
    <?php endif; ?>

    function redirectToUsers() {
      window.location.href = 'users.php';
    }
  </script>
</body>

</html>

<?php
$conn->close();
?>
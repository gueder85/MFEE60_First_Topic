<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入id到此頁";
  exit;
}
$id = $_GET["id"];

$sql = "SELECT article.*, category.name 
FROM article 
JOIN category ON article.category_id = category.id
WHERE article.id='$id'
AND is_deleted=0
";


$result = $conn->query($sql);
$row = $result->fetch_assoc();


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
  <!-- Summernote CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <!-- Summernote JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
  <style>
    .select-width {
      width: 15%;
      /* 設置寬度為父容器的 100% */
      max-width: 400px;
      /* 設置最大寬度 */
      min-width: 150px;
      /* 設置最小寬度 */
    }

    #summernote {
      white-space: pre-wrap;
      /* 保持空格並讓文本自動換行 */
      word-wrap: break-word;
      /* 防止長單詞或 URL 不換行 */
      overflow-wrap: break-word;
      /* 強制長字詞換行 */
    }
  </style>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">文章修改</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
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

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            確認刪除該文章?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
            <a href="doDeleteArticle.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                <h5 class="text-white text-capitalize ps-3">文章修改</h5>
              </div>
            </div>
            <div class="container">
              <div class="pt-4">
                <a class="btn btn-light" href="article.php"><i class="fa-solid fa-circle-left fa-lg"></i> 返回</a>
              </div>
              <?php if ($result->num_rows > 0): ?>
                <form action="doUpdateArticle.php" method="post" enctype="multipart/form-data">
                  <table class="table table-bordered">
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <tr>
                      <th>編號</th>
                      <td><?= $row["id"] ?></td>
                    </tr>
                    <tr>
                      <th>標題</th>
                      <td><input type="title" class="form-control" name="title" value="<?= $row["title"] ?>"></td>
                    </tr>
                    <tr>
                      <th>作者</th>
                      <td><input type="author" class="form-control" name="author" value="<?= $row["author"] ?>"></td>
                    </tr>
                    <?php
                    $date = date('Y-m-d', strtotime($row["created_at"])); // 將日期格式化為 YYYY-MM-DD
                    ?>
                    <tr>
                      <th>發布時間</th>
                      <td>
                        <input class="select-width" type="date" value="<?= $date ?>" name="created_at">
                      </td>
                    </tr>
                    <?php
                    // 查詢所有類別
                    $category_sql = "SELECT id, name FROM category";
                    $category_result = $conn->query($category_sql);
                    ?>
                    <tr>
                      <th>類別</th>
                      <td>
                        <select class="form-select contentBorder p-2 select-width" aria-label="Default select example" name="category" value="">
                          <option value="" disabled>請點選</option>
                          <?php while ($category_row = $category_result->fetch_assoc()): ?>
                            <option value="<?= $category_row['id'] ?>" <?= $category_row['id'] == $row['category_id'] ? 'selected' : '' ?>>
                              <?= htmlspecialchars($category_row['name']) ?>
                            </option>
                          <?php endwhile; ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>內容</th>
                      <td>
                        <div class=" mt-3">
                          <textarea id="summernote" name="content"><?= htmlspecialchars(nl2br($row["content"])) ?></textarea>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <div class="d-flex justify-content-between">
                    <div>
                      <button id="submitButton" class="btn btn-light" type="submit">儲存</button>
                      <a class="btn btn-light" href="article.php">取消</a>
                    </div>
                    <div>
                      <div>
                        <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">刪除</a>
                      </div>
                    </div>
                  </div>
                </form>
              <?php else: ?>
                <h1>找不到使用者</h1>
              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </main>
  <script>
    $(document).ready(function() {
      $('#summernote').summernote({
        width: 800,
        height: 500,
        focus: true
      });

      $('#submitButton').on('click', function() {
        var content = $('#summernote').val();
        alert(content); // 顯示編輯器內容
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
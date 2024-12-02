<?php
require_once("../../db_connect.php");

// 初始化分頁變數
$p = isset($_GET["p"]) ? intval($_GET["p"]) : 1;
$per_page = 10;
$start_item = ($p - 1) * $per_page;
// $total_page = ceil($productAllCount / $per_page);
$sqlAll = "SELECT * FROM product WHERE is_deleted=0";
$resultAll=$conn->query($sqlAll);
$productAllCount=$resultAll->num_rows;
$total_page = ceil($productAllCount / $per_page);
// $sqlAll = "SELECT * FROM product WHERE is_deleted=0";
// $resultAll=$conn->query($sqlAll);
// $userAllCount=$resultAll->num_rows;


//取所有品牌for品牌篩選
$sqlBrand = "SELECT * FROM brand";
$resultBrand = $conn->query($sqlBrand);
$brands = $resultBrand->fetch_all(MYSQLI_ASSOC);


// 初始化查詢條件
$where_conditions = ["product.is_deleted = 0"];

// 品牌篩選邏輯
if (isset($_GET["selectedBrand"]) && !empty($_GET["selectedBrand"])) {
  $selectedBrand = $_GET["selectedBrand"];
  $where_conditions[] = "brand.name = '$selectedBrand'";

  // 重新計算總筆數和總頁數
  $sqlCount = "SELECT COUNT(*) as count 
    FROM product 
    JOIN brand ON product.brand_id = brand.id
    WHERE product.is_deleted = 0 AND brand.name = '$selectedBrand'";
  $resultCount = $conn->query($sqlCount);
  $countRow = $resultCount->fetch_assoc();
  $productAllCount = $countRow['count'];
  $total_page = ceil($productAllCount / $per_page);
}
// else if (isset($_GET["p"])) {
//   $p = $_GET["p"];
//   $start_item = ($p - 1) * $per_page;
//   $total_page= ceil($userAllCount / $per_page); 
// }else{
//   header("location: product-list.php?p=1");
// }

// 搜尋功能
if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $where_conditions[] = "product.name LIKE '%$search%'";

  // 重新計算總筆數和總頁數
  $sqlCount = "SELECT COUNT(*) as count 
    FROM product 
    WHERE product.is_deleted = 0 AND product.name LIKE '%$search%'";
  $resultCount = $conn->query($sqlCount);
  $countRow = $resultCount->fetch_assoc();
  $productAllCount = $countRow['count'];
  $total_page = ceil($productAllCount / $per_page);
}
// else if (isset($_GET["p"])) {
//   $p = $_GET["p"];
//   $start_item = ($p - 1) * $per_page;
//   $total_page = ceil($userAllCount / $per_page);
// } else {
//   header("location: product-list.php?p=1");
// }

// 組合 WHERE 子句
$where_clause = implode(" AND ", $where_conditions);

$sql = "SELECT product.*, brand.name AS brand_name, images.image 
FROM product 
JOIN brand ON product.brand_id = brand.id
JOIN images ON product.main_image_id = images.id
WHERE $where_clause
ORDER BY product.id ASC
LIMIT $start_item, $per_page";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>


<!-- // //取所有品牌for品牌篩選
// $sqlBrand = "SELECT * FROM brand";
// $resultBrand = $conn->query($sqlBrand);
// $brands = $resultBrand->fetch_all(MYSQLI_ASSOC);

// if (isset($_GET["search"])) {
//   //搜尋產品名稱
//   $search = $_GET["search"];
//   $sql = "SELECT product.*, brand.name AS brand_name, images.image FROM product 
//   JOIN brand ON product.brand_id = brand.id
//   JOIN images ON product.main_image_id = images.id
//   WHERE product.name LIKE '%$search%' AND product.is_deleted = 0
//   ORDER BY product.id ASC
//   ";
// } else {
//   $sql = "SELECT product.*, brand.name AS brand_name, images.image FROM product 
//   JOIN brand ON product.brand_id = brand.id
//   JOIN images ON product.main_image_id = images.id
//   WHERE product.is_deleted = 0
//   ORDER BY product.id ASC
//   ";
// }

// $result = $conn->query($sql);
// $rows = $result->fetch_all(MYSQLI_ASSOC); -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    product list
  </title>
  <?php include("../css.php") ?>

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

    .page-link.active, .active>.page-link {
      background-color: #262626;
      color: #fff;
      border: none;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include("../../sidebar.php") ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include("../navbar.php") ?>
    <!-- Product List -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 px-2 d-flex justify-content-between align-items-center">
                <div>
                <h4 class="text-white text-capitalize ps-3 mb-0">商品列表</h4>  
                <div class="ps-3 text-secondary pt-1">共計<?= $productAllCount ?>個商品</div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                  <div class="card bg-light me-3">
                    <a href="product-add.php">
                      <div class="card-body py-2 px-3 text-sm font-weight-bolder">
                        新增商品 <i class="fa-solid fa-plus"></i>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <!-- search -->
              <div class="row mt-4">
                <div class="col-3">
                  <form action="" method="get">
                    <select name="selectedBrand" class="form-control" style="height: 42.4px;" onchange="this.form.submit()">
                      <option value="">全部品牌</option>
                      <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand["name"] ?>" <?= (isset($_GET['selectedBrand']) && $_GET['selectedBrand'] == $brand["name"]) ? 'selected' : '' ?>><?= $brand["name"] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </form>
                </div>
                <div class="col-4">
                  <form action="" method="get">
                    <div class="input-group input-group-outline">
                      <input type="search" class="form-control" style="    border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" name="search" placeholder="請輸入商品名稱" value="<?= $_GET["search"] ?? "" ?>">
                      <button class="btn btn-light m-0" type="submit"><i class="fa-solid fa-magnifying-glass fa-fw"></i>
                      </button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-secondary text-xs font-weight-bolder opacity-7">商品名稱</th>
                      <th class="text-center text-xs font-weight-bolder opacity-7">品牌</th>
                      <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">顏色</th>
                      <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">(拾音器)規格</th>
                      <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">價錢</th>
                      <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">編輯</th>
                      <!-- <th class="text-secondary opacity-7"></th> -->
                    </tr>
                  </thead>
                  <!-- 產品資料跑迴圈 -->
                  <tbody>
                    <?php foreach ($rows as $product): ?>
                      <!-- 組商品顏色陣列 -->
                      <?php
                      $sqlColorName = "SELECT product_color.*, color.name AS color_name FROM product_color 
                        JOIN color ON product_color.color_id = color.id 
                        WHERE product_id =" . $product["id"];
                      $resultColorName = $conn->query($sqlColorName);
                      $rowsColorName = $resultColorName->fetch_all(MYSQLI_ASSOC);
                      ?>

                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img src="../product_upload/<?= $product["image"] ?>" class="avatar avatar-sm object-fit-contain me-3 border-radius-lg" alt="">
                            </div>
                            <div class="d-flex align-items-center">
                              <a href="product-detail.php?id=<?= $product["id"] ?>">
                                <h6 class="mb-0 text-sm"><?= $product["name"] ?></h6>
                              </a>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <p class="text-xs font-weight-bold mb-0"><?= $product["brand_name"] ?></p>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <!-- 撈商品顏色 -->
                          <?php foreach ($rowsColorName as $ColorName): ?>
                            <p class="text-xs font-weight-bold mb-0"><?= $ColorName["color_name"] ?></p>
                          <?php endforeach; ?>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <p class="text-xs font-weight-bold mb-0"><?= $product["spec"] ?></p>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold">$<?= number_format($product["price"]) ?></span>
                        </td>
                        <td class="align-middle text-center">
                          <a href="product-edit.php?id=<?= $product["id"] ?>" class="text-secondary font-weight-bold text-s p-2 ">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </a>
                        </td>
                        <!-- <td class="align-middle text-center">
                          <a href="" class="text-secondary font-weight-bold text-s  p-2" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="fa-solid fa-trash"></i>
                          </a>
                        </td> -->
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

        <nav aria-label="Page navigation example">
          <ul class="pagination d-flex justify-content-center">
            <?php
            $baseUrl = "product-list.php?";
            $params = [];
            if (isset($_GET["selectedBrand"]) && !empty($_GET["selectedBrand"])) {
              $params[] = "selectedBrand=" . $_GET["selectedBrand"];
            }else if (isset($_GET["search"]) && !empty($_GET["search"])) {
              $params[] = "search=" . $_GET["search"];
            }

            for ($i = 1; $i <= $total_page; $i++):
              $linkParams = array_merge($params, ["p=" . $i]);
              $link = $baseUrl . implode("&", $linkParams);
            ?>
              <li class="page-item <?= ($i == $p) ? "active" : "" ?>">
                <a class="page-link" style="background-color: ;" href="<?= $link ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>

      <footer class="footer py-4">
      </footer>
    </div>
  </main>

  <?php include("../js.php") ?>
</body>

</html>
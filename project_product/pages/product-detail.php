<?php
require_once("../../db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入id到此頁";
  exit;
}

$id = $_GET["id"];

// $sql = "SELECT * FROM product WHERE id = $id AND is_deleted=0";
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();

$sql = "SELECT product.*, brand.name AS brand_name, images.image FROM product 
JOIN brand ON product.brand_id = brand.id
JOIN images ON product.main_image_id = images.id
WHERE product.id = $id AND product.is_deleted=0
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlColorName = "SELECT product_color.*, color.name AS color_name FROM product_color 
JOIN color ON product_color.color_id = color.id 
WHERE product_id =" . $row["id"];
$resultColorName = $conn->query($sqlColorName);
$rowsColorName = $resultColorName->fetch_all(MYSQLI_ASSOC);

// $sqlImg = "SELECT * FROM images";
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    product detail
  </title>
  <?php include("../css.php") ?>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- Modal -->
  <div class="modal fade modal-sm" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          確定刪除此商品?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
          <a href="doDeleteProduct.php?id=<?= $row["id"] ?>" type="button" class="btn btn-primary">確認</a>
        </div>
      </div>
    </div>
  </div>

  <?php include("../../sidebar.php") ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include("../navbar.php") ?>
    <!-- Product List -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 d-flex justify-content-between align-items-center">
                <h6 class="text-white text-capitalize ps-3 mb-0"><?= $row["name"] ?> 商品資訊</h6>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="card bg-light me-3">
                    <a href="product-edit.php?id=<?= $id ?>">
                      <div class="card-body py-2 px-3 text-sm font-weight-bolder">
                        編輯 <i class="fa-solid fa-pen-to-square"></i>
                      </div>
                    </a>
                  </div>
                  <div class="card bg-light me-3">
                    <a href="" data-bs-toggle="modal" data-bs-target="#confirmModal">
                      <div class="card-body py-2 px-3 text-sm font-weight-bolder">
                        刪除 <i class="fa-solid fa-trash"></i>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-5 pb-2">
            <div class="card bg-white mb-4" style="width: 80px;">
                    <a href="product-list.php">
                      <div class="card-body py-2 px-3 text-sm">
                      <i class="fa-solid fa-chevron-left"></i> 返回
                      </div>
                    </a>
                  </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">ID</div>
                <div class="ms-5"><?= $row["id"] ?></div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">商品名稱</div>
                <div class="ms-5"><?= $row["name"] ?></div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">品牌</div>
                <div class="ms-5"><?= $row["brand_name"] ?></div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">顏色</div>
                <?php foreach ($rowsColorName as $rowColorName): ?>
                  <div class="ms-5"><?= $rowColorName["color_name"] ?></div>
                <?php endforeach; ?>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">規格</div>
                <div class="ms-5"><?= $row["spec"] ?></div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">價錢</div>
                <div class="ms-5">$ <?= number_format($row["price"]) ?></div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">商品描述</div>
                <div class="ms-5" style="max-width: 900px;">
                  <?= $row["discription"] ?>
                </div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">最後更新時間</div>
                <div class="ms-5"><?= $row["last_updated"] ?></div>
              </div>
              <div class="d-flex mb-4">
                <div for="" class="m-0 col-1">商品圖</div>
                <div class="ms-1 ratio ratio-4x3" style="max-width: 500px;">
                  <img src="../product_upload/<?= $row["image"] ?>" class="object-fit-contain w-100 h-100" alt="">
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer py-4">
      </footer>
    </div>
  </main>

  <?php include("../js.php") ?>
</body>

</html>
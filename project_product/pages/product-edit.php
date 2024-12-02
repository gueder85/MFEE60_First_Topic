<?php
require_once("../../db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入id到此頁";
  exit;
}

$id = $_GET["id"];

//取得當前的資訊
$sql = "SELECT product.*, brand.name AS brand_name FROM product 
JOIN brand ON product.brand_id = brand.id
WHERE product.id = $id AND product.is_deleted=0
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlColorName = "SELECT product_color.*, color.name AS color_name FROM product_color 
JOIN color ON product_color.color_id = color.id 
WHERE product_id =" . $row["id"];
$resultColorName = $conn->query($sqlColorName);
$rowsColorName = $resultColorName->fetch_all(MYSQLI_ASSOC);

//品牌選單
$sqlBrand = "SELECT * FROM brand";
$resultBrand = $conn->query($sqlBrand);
$brands = $resultBrand->fetch_all(MYSQLI_ASSOC);

//顏色選單
$sqlColor = "SELECT * FROM color";
$resultColor = $conn->query($sqlColor);
$colors = $resultColor->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    product edit
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

    #member_id {
      border: none;
      background-color: transparent;
      box-shadow: none;
    }
  </style>
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
          <a href="doDeleteProduct.php?id=<?= $row["id"] ?>" type="button" class="btn btn-danger">確認</a>
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
          <div class="card">
            <div class="card-header pb-0">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <h6 class="text-white fw-normal ps-4">更新商品資訊</h6>
              </div>
            </div>
            <div class="card-body">
              <form action="doEditProduct.php" method="post" enctype="multipart/form-data">
                <div class="d-flex mb-3 col-lg-6">
                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                  <!-- <label for="" class="form-label">ID -</label> -->
                  <!-- <div class="ms-2"><?= $row["id"] ?></div> -->
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">商品名稱</label>
                  <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">品牌</label>
                  <!-- select 待修改 -->
                  <select class="form-control" name="brand" required>
                    <?php foreach ($brands as $brand): ?>
                      <option value="<?=$brand["id"]?>">
                        <?= $brand["name"] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group mb-3 col-lg-6">
                  <label for="">顏色</label>
                  <!-- select 待修改 -->
                  <select class="form-control" name="color" required>
                  <?php foreach($colors as $color):?>
                      <option value="<?=$color["id"]?>">
                      <?=$color["name"]?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">規格</label>
                  <input type="text" class="form-control" name="spec" value="<?= $row["spec"] ?>">
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">價錢</label>
                  <input type="text" class="form-control" name="price" value="<?= number_format($row["price"]) ?>" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">商品描述</label>
                  <input type="text" class="form-control" name="discription" value="<?= $row["discription"] ?>" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">商品圖</label>
                  <input type="hidden" name="main_image_id" value="<?= $row["main_image_id"] ?>">
                  <input type="file" class="form-control ps-0" style="font-size: 1rem;" name="myFile" accept="image/*" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">最後更新時間</label>
                  <div class="ms-2"><?= $row["last_updated"] ?></div>
                </div>
                <div class="d-flex justify-content-between col-lg-6">
                  <a type="" class="btn btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#confirmModal">刪除 <i class="fa-solid fa-trash"></i></a>
                  <div>
                    <a href="product-list.php" class="btn btn-dark mt-5 ms-2">取消</a>
                    <button type="submit" class="btn btn-dark mt-5">儲存</button>
                  </div>
                </div>
              </form>
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
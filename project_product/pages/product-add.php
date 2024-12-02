<?php
require_once("../../db_connect.php");

//取所有品牌
$sqlBrand = "SELECT * FROM brand";
$resultBrand = $conn->query($sqlBrand);
$brands = $resultBrand->fetch_all(MYSQLI_ASSOC);

//取所有顏色
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
    product add
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
          <div class="card">
            <div class="card-header pb-0">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                <h6 class="text-white fw-normal ps-4">新增商品</h6>
              </div>
            </div>
            <div class="card-body">
              <form action="doAddProduct.php" method="post" enctype="multipart/form-data">
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">商品名稱</label>
                  <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">品牌</label>
                  <!-- select 待修改 -->
                  <select name="brand" class="form-control">
                    <?php foreach($brands as $brand):?>
                    <option value="<?=$brand["id"]?>"><?=$brand["name"]?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label for="" class="form-label">顏色</label>
                  <!-- select 待修改 -->
                  <select name="color" class="form-control">
                    <?php foreach($colors as $color):?>
                    <option value="<?=$color["id"]?>"><?=$color["name"]?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">規格</label>
                  <input type="text" class="form-control" name="spec" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">價錢</label>
                  <input type="number" class="form-control" id="" name="price" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="" class="form-label">商品描述</label>
                  <input type="text" class="form-control" name="discription" required>
                </div>
                <div class="mb-3 col-lg-6">
                  <!-- 商品圖待修改 -->
                  <label for="" class="form-label">商品圖</label>
                  <input type="file" class="form-control ps-0" style="font-size: 1rem;" name="myFile" accept="image/*" required>
                </div>
                <div class="mb-3 col-lg-6 d-flex justify-content-end">
                  <a href="product-list.php" class="btn btn-dark mt-5">取消</a>
                  <button type="submit" class="btn btn-dark mt-5 ms-2">送出</button>
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
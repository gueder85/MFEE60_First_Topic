<?php
require_once("../../db_connect.php");

if (!isset($_GET["id"])) {
  echo "請帶入id到此頁面";
  exit;
}

//coupons_type
$cateSql = "SELECT * FROM coupons_type";
$resultCate = $conn->query($cateSql);
$categories = $resultCate->fetch_all(MYSQLI_ASSOC);



$whereClause = "";
if (isset($_GET["category"])) {
  $categoryId = $_GET["category"];
  $whereClause = "WHERE coupons_select.type_id = $categoryId";
  $typeSql = "SELECT * FROM coupons_type WHERE coupons_type.id = $categoryId";
  $resultType = $conn->query($typeSql);
  $types = $resultType->fetch_all(MYSQLI_ASSOC);
  $typesArr = [];
  foreach ($types as $type) {
    $typesArr[$type["id"]] = $type["category"];
  }
  //要送出去的category
}
// End--coupons_type--


//coupons_select
$seleSql = "SELECT * FROM coupons_select
$whereClause
";
$resultSelect = $conn->query($seleSql);
$selects = $resultSelect->fetch_all(MYSQLI_ASSOC);
$selectsArr = [];
foreach ($selects as $select) {
  $selectsArr[$select["id"]] = $select["name"];
}
// End--coupons_select--

//coupons
$id = $_GET["id"];
$sql = "SELECT * FROM coupons WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute(); // execute() 必須在 fetch_all() 之前執行
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//get_result() 函數會返回一個 mysqli_result 物件，然後再使用 fetch_all() 函數來提取所有資料。
// End--coupons--


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Material Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> 請求失敗-->
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>修改優惠券</title>
  <style>
    #coupons .active {
      font-weight: 900;
      color: aliceblue;
      /* background-color: rgb(246, 95, 35); */
      background-color: #eee;

    }

    #coupons .form-select {
      background-color: aliceblue;
      padding-left: 10px;
    }
  </style>
</head>

<body>
  <div class="container-fluid py-2">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
      <?php include("../../sidebar.php") ?>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <div class="row w-50" id="coupons">
        <div class=" d-flex justify-content-between">
          <a class="btn btn-dark" href="coupons.php"><i class="fa-solid fa-right-to-bracket"></i></a>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
            刪除
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">刪除資料</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  確定刪除?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                  <button type="button" class="btn btn-danger"> <a class="btn-danger" href="doDeleted.php?id=<?= $_GET["id"] ?>">刪除</a>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal End -->

        </div>
        <div>
          <h3 class="mb-0 h4 font-weight-bolder">修改優惠券</h3>
        </div>
        <form>
          <div class="mb-4 d-inline-flex">
            <label for="">優惠類型</label>
            <input type="hidden" name="type" id="category_id" value="<?= $type["category"] ?> "> <!-- 新增隱藏欄位 -->
          </div>
          <div class="d-inline-flex ">
            <?php foreach ($categories as $category): ?>
              <ul class="nav nav-underline mb-3 ">
                <li class="nav-item ms-2 me-2 p-1">
                  <a href="coupons-edit.php?category=<?= $category["id"] ?>&id=<?= $id ?>" class="text-dark nav-link p-2 <?php if (isset($_GET["category"]) && $_GET["category"] == $category["id"]) echo "active" ?>" id="type_select"><?= $category["category"] ?></a>

                </li>
              </ul>
            <?php endforeach; ?>
          </div>
          <?php if (isset($_GET["category"])): ?>
            <div class="mb-4 ">
              <label for="" class="form-label">優惠券名稱</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-4 ">
              <label for="" class="form-label">折扣</label>
              <input type="hidden" name="discount_type" id="discount_type" value="<?= $selectsArr[$select["id"]] ?>">
              <!-- 新增隱藏欄位 -->
              <?php if (isset($category["id"]) && ($category["id"] == 3)): ?>
                <select class="form-select mb-2" aria-label="Default select example" id="discount_select" onchange="updateDiscountType()">
                  <!-- <option selected>請選擇</option> -->
                  <?php foreach ($selects as $select): ?>
                    <option value="<?= $selectsArr[$select["id"]] ?>"><?= $selectsArr[$select["id"]] ?></option>
                  <?php endforeach; ?>
                </select>
              <?php else: ?>
              <?php endif; ?>

              <input type="text" class="form-control" name="discount" id="discount_text" required>
            </div>

            <div class="mb-4">
              <label for="" class="form-label">優惠券可使用期間</label>

              <input type="date" id="time" name="str-time" required>~
              <input type="date" id="time" name="end-time" required>
              <input type="hidden" name="id" value="<?= $id ?>">
              <button type="submit" class="btn btn-dark mb-2" id="button1">送出</button>
              <button type="submit" class="btn btn-dark mb-2" id="button2">確認</button>

            </div>
          <?php else: ?>

          <?php endif; ?>
        </form>

      </div>
      <div class="row">

        <!-- 測試中表單 -->
        <div class="col-12 mt-4">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-2 pb-1">
                <h6 class="text-white text-capitalize ps-3">優惠券資訊</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary  opacity-7">Name</th>
                      <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Type</th>
                      <th class="text-center text-uppercase text-secondary  opacity-7">discount Type</th>
                      <th class="text-center text-uppercase text-secondary  opacity-7">discount</th>
                      <th class="text-center text-uppercase text-secondary  opacity-7">Start</th>
                      <th class="text-center text-uppercase text-secondary  opacity-7">End</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($results as $row): ?>
                      <tr class="mt-3">
                        <td class="text-center w-10 py-3">
                          <h6 class="mb-0 text-md"><?= $row["name"] ?></h6>
                        </td>
                        <td>
                          <p class="text-center text-md font-weight-bold mb-0"><?= $row["type"] ?></p>
                        </td>
                        <td class="text-center w-10 py-3">
                          <p class="text-md font-weight-bold mb-0"><?= $row["discount_type"] ?></p>
                        </td>
                        <td class="text-center w-10 py-3">
                          <p class="text-md font-weight-bold mb-0"><?= $row["discount"] ?></p>
                        </td>
                        <td class="align-middle text-center text-lg">
                          <span class="badge badge-sm bg-gradient-success"><?= $row["str_time"] ?></span>
                        </td>
                        <td class="align-middle text-center text-lg">
                          <span class="badge badge-sm bg-gradient-danger"><?= $row["end_time"] ?></span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    const myModal = document.getElementById('exampleModal')

    myModal.addEventListener('shown.bs.modal', () => {})

    function sendData() {
      let selectElement = document.getElementById("discount_select");
      let selectedValue = selectElement.value;
      document.getElementById("discount_type").value = selectedValue;
    }

    function updateDiscountType() {
      sendData();
      const discountValueInput = document.getElementById('discount_type');
      const discountTextValueInput = document.getElementById('discount_text');
      if (discountValueInput.value === '折扣折數') {
        discountTextValueInput.value = '%';
      }else if (discountValueInput.value === '免運費') {
        discountTextValueInput.value = '100%';
      } else {
        discountTextValueInput.value = '';
      }
    }

    function updateField(id) {
      const form = document.querySelector("form");
      const formData = new FormData(form);
      // formData.append("id", id) 如果整個form寄送收不到 就要單獨寄出

      fetch('updata_data.php', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          console.log(response);
          return response.json();
        })
        .then(date => {
          if (data.status === 0) {
            data.errors.forEach(error => {
              alert(`請輸入${error.message}`); //顯示錯誤訊息
            });
          }
        })
        .then(data => {
            console.log(data);
            if (data.error) {
              alert('更新失敗: ' + data.error);
              return;
            }
            console.log('更新成功');
            document.querySelector("input[name=name]").value = data.updatedValue;
            })
            // .catch(error => {
            //   console.error('Error:', error);
            //   alert('發生錯誤！請檢查網路連線或聯絡網站管理員。');
            // });  
            //更新成功依然跑失敗 需要解決

          }

          const btn1 = document.getElementById("button1");
          const btn2 = document.getElementById("button2");


          btn1.addEventListener("click", function(e) {
            e.preventDefault();
            const id = document.querySelector("input[name=id]").value;
            const discount_type = document.querySelector("input[name=discount_type]").value;
            const discount = document.querySelector("input[name=discount]").value;
            const str_time = document.querySelector("input[name=str-time]").value;
            const end_time = document.querySelector("input[name=end-time]").value;
            updateField(id);
          })
  </script>
</body>

</html>
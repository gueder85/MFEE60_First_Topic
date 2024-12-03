<?php
require_once("../../db_connect.php");


$cateSql = "SELECT * FROM coupons_type";
$resultCate = $conn->query($cateSql);
$categories = $resultCate->fetch_all(MYSQLI_ASSOC);

$whereClause = "";
if (isset($_GET["category"])) {
  $categoryId = $_GET["category"];
  $whereClause = "WHERE coupons_select.type_id = $categoryId";
}

$seleSql = "SELECT * FROM coupons_select
$whereClause
";
$resultSelect = $conn->query($seleSql);
$selects = $resultSelect->fetch_all(MYSQLI_ASSOC);
$selectsArr = [];
foreach ($selects as $select) {
  $selectsArr[$select["id"]] = $select["name"];
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
    新增優惠券
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    #coupons .active {
      font-weight: 900;
      color: aliceblue;
      background-color: #eee;
    }

    #coupons .form-select {
      background-color: aliceblue;
      padding-left: 10px;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <?php include("../../sidebar.php") ?>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container-fluid py-2">
      <div class="row" id="coupons">
        <div class="ms-1 mt-3 mb-3">
          <a class="btn btn-dark" href="coupons.php"><i class="fa-solid fa-right-to-bracket"></i></a>

          <h3 class="mb-0 h4 font-weight-bolder">新增優惠券</h3>
        </div>
        <form action="../coupon-data/coupons.php" class="w-50 text-start" method="post">
          <div class="mb-4 d-inline-flex">
            <label for="">優惠類型</label>
            <input type="hidden" name="category_id" id="category_id" value="<?= $categoryId ?>"> <!-- 新增隱藏欄位 -->
          </div>
          <div class="d-inline-flex ">
            <?php foreach ($categories as $category): ?>
              <ul class="nav nav-underline mb-3 ">
                <li class="nav-item ms-2 me-2 p-1">
                  <a href="coupons-create.php?category=<?= $category["id"] ?>" class="text-dark  nav-link p-2 <?php if (isset($_GET["category"]) && $_GET["category"] == $category["id"]) echo "active" ?>"><?= $category["category"] ?></a>

                </li>
              </ul>
            <?php endforeach; ?>


          </div>
          <?php if (isset($_GET["category"])): ?>
            <div class="mb-4 ">
              <label for="" class="form-label">優惠券名稱</label>
              <input type="text" class="form-control" name="name">
            </div>

            <div class="mb-4 ">
              <label for="" class="form-label">折扣</label>
              <input type="hidden" name="discount_type" id="discount_type" value="<?= $selectsArr[$select["id"]] ?>">
              <!-- 新增隱藏欄位 -->

              <?php if (isset($category["id"]) && ($category["id"] == 3)): ?>
                <select class="form-select mb-2" aria-label="Default select example" id="discount_select" onchange="updateDiscountType()">
                  <?php foreach ($selects as $select): ?>
                    <option value="<?= $selectsArr[$select["id"]] ?>"><?= $selectsArr[$select["id"]] ?></option>
                  <?php endforeach; ?>
                </select>
              <?php else: ?>

              <?php endif; ?>
              <input type="text" class="form-control" name="discount" id="discount_text">
            </div>

            <div class="mb-4">
              <label for="" class="form-label">優惠券可使用期間</label>

              <input type="date" id="time" name="str-time">~
              <input type="date" id="time" name="end-time">
              <button type="submit" class="btn btn-dark mb-2">送出</button>

            </div>
          <?php else: ?>

          <?php endif; ?>

        </form>
      </div>
      <div class="row">

      </div>
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>,
                made by
                康鈞毅
                .
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About
                    Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                    target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Views",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: [50, 45, 22, 28, 50, 60, 76],
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
          label: "Sales",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [4, 4]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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
  <script>
    let Active = document.querySelectorAll("#option");

    Active.forEach((active, index) => {
      active.addEventListener("click", function() {
        Active.forEach((active) => active.classList.remove("active"));
        Active[index].classList.add("active");
      })
    })

    function selectCategory($categoryId) {
      document.getElementById("category_id").value = $categoryId;
    }

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
      } else if (discountValueInput.value === '免運費') {
        discountTextValueInput.value = '100%';
      } else {
        discountTextValueInput.value = '';
      }
    }

    if (isset(selectedValue) && (selectedValue == "2")) {
      let discount_text = document.getElementById("discount_text");
      discount_text.textContent = String(discount_text.textContent) + "%";
    }
  </script>
</body>

</html>
<?php
require_once("../assets/sqls-activity.php");

// 活動物件
$act = new Activity($conn);

// 條件1 : 排序 (預設 ASC)
$order = $_GET["order"] ?? 0;
$condition1 = "?order=" . $order;

// 條件2 : 篩選列
$date_start = $_GET["date_start"] ?? null;
$condition2 = "&date_start=" . $date_start;

$date_end = $_GET["date_end"] ?? null;
$condition2 .= "&date_end=" . $date_end;

$city_id = $_GET["city_id"] ?? null;
$condition2 .= "&city_id=" . $city_id;

$category_id = $_GET["category_id"] ?? null;
$condition2 .= "&category_id=" . $category_id;

// 條件整合
$condition = $condition1 . $condition2;

// 獨立條件 (有查詢就忽略前面條件)
$search = $_GET["search"] ?? null;

// 分頁設定
$per_page = 10;
$p = isset($_GET["p"]) ? intval($_GET["p"]) : 1;
$start_item = ($p - 1) * $per_page;

$rows = $act->read($order, $search, $date_start, $date_end, $city_id, $category_id, $start_item, $per_page);
// echo $rows["sql"];

$cates = $act->readCategory();
$cities = $act->readCity();
?>

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-lg text-dark active" aria-current="page">活動管理</li>
            </ol>
        </nav> -->
        <form action="" method="get">
            <div class="d-flex align-items-center ">
                <div class="col-auto">
                    <h6 class="mb-0 me-3">活動開始日</h6>
                </div>
                <div class="col-auto">
                    <input type="date" class="form-control" name="date_start" value="<?= $_GET["date_start"] ?? null; ?>">
                </div>
                <div class="col-1 text-center">~</div>
                <div class="col-auto">
                    <input type="date" class="form-control" name="date_end" value="<?= $_GET["date_end"] ?? null; ?>">
                </div>
                <div class="col-auto">
                    <h6 class="mb-0 ms-5 me-3">音樂</h6>
                </div>
                <div class="col-auto">
                    <select class="form-select" name="category_id">
                        <option value='' selected>選擇類型</option>
                        <?php foreach ($cates as $cate): ?>
                            <option value="<?= $cate['id'] ?>"
                                <?= ($_GET['category_id'] ?? null)  == $cate['id'] ? 'selected' : '' ?>>
                                <?= $cate['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <h6 class="mb-0 ms-5 me-3">城市</h6>
                </div>
                <div class="col-auto">
                    <select class="form-select" name="city_id">
                        <option value='' selected>選擇縣市</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= $city['id'] ?>"
                                <?= ($_GET['city_id'] ?? null)  == $city['id'] ? 'selected' : '' ?>>
                                <?= $city['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-auto">
                    <button class="btn btn-dark mb-0 ms-4" type="submit">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-end">
                <form action="" method="get">
                    <div class="input-group input-group-outline">
                        <label class="form-label">搜尋活動名稱</label>
                        <input type="text" class="form-control" name="search">
                    </div>
                </form>
            </div>

            <!-- <ul class="navbar-nav d-flex align-items-center  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank"
                    href="https://www.creative-tim.com/builder?ref=navbar-material-dashboard">Online Builder</a>
                </li>
                <li class="mt-1">
                <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                    data-icon="octicon-star" data-size="large" data-show-count="true"
                    aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                </li>
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
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
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
                            <img src="../assets/img/small-logos/logo-spotify.svg"
                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
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
                            <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>credit-card</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                    <g transform="translate(453.000000, 454.000000)">
                                    <path class="color-background"
                                        d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                        opacity="0.593633743"></path>
                                    <path class="color-background"
                                        d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                    </path>
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
            </ul> -->
        </div>
    </div>
</nav>


<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <!-- heading -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-3 pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-white fw-normal fs-5 ps-4">活動列表</span>
                            <a class="btn btn-outline-light text-white btn-sm mb-0 me-3"  href="?page=3">新增活動</a>
                        </div>
                        <div class="text-secondary fw-normal fs-6 ps-4 mt-1 mb-2"><small>共計 <?= $rows["num_rows"] ?> 項活動</small></div>
                    </div>
                </div>

                <!-- content -->
                <div class="card-body px-0 pb-2">
                    <table class="table align-items-center mb-0" style="table-layout: fixed;">
                        <!-- thead -->
                        <thead>
                            <tr>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">
                                    <a href="?order=<?= ($order == 0) ? 1 : 0 ?><?= $condition2 ?>">編號
                                        <i class="ms-1 fa-solid 
                                        <?= ($order == 0) ? 'fa-sort-up' : (($order == 1) ? 'fa-sort-down' : '') ?>
                                    ">
                                        </i>
                                    </a>
                                </th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">活動</th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">名稱</th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">音樂類型</th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">演出參與</th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">
                                    <a href="?order=<?= ($order == 6) ? 7 : 6 ?><?= $condition2 ?>">活動日期
                                        <i class="ms-1 fa-solid 
                                        <?= ($order == 6) ? 'fa-sort-up' : (($order == 7) ? 'fa-sort-down' : '') ?>
                                    ">
                                        </i>
                                    </a>
                                </th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">報名日期</th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">
                                    <a href="?order=<?= ($order == 4) ? 5 : 4 ?><?= $condition2 ?>">門票數量
                                        <i class="ms-1 fa-solid 
                                        <?= ($order == 4) ? 'fa-sort-up' : (($order == 5) ? 'fa-sort-down' : '') ?>
                                    ">
                                        </i>
                                    </a>
                                </th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">
                                    <a href="?order=<?= ($order == 2) ? 3 : 2 ?><?= $condition2 ?>">門票價格
                                        <i class="ms-1 fa-solid 
                                        <?= ($order == 2) ? 'fa-sort-up' : (($order == 3) ? 'fa-sort-down' : '') ?>
                                    ">
                                        </i>
                                    </a>
                                </th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">描述</th>
                                <th class="text-center text-secondary text-md font-weight-bolder opacity-7">城市</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>

                        <!-- tbody -->
                        <tbody>
                            <?php foreach ($rows["rows"] as $row): ?>
                                <?php
                                // 刪除其對應的id
                                $images = $act->readMedia($row["id"]);
                                $bands = $act->readBand($row["id"]);

                                // 資料處理
                                $date_start = date("Y-m-d H:i", strtotime($row["date_start"]));
                                $date_end = date("Y-m-d H:i", strtotime($row["date_end"]));
                                $sign_up_start = date("Y-m-d H:i", strtotime($row["sign_up_start"]));
                                $sign_up_end = date("Y-m-d H:i", strtotime($row["sign_up_end"]));
                                ?>

                                <tr>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?= $row["id"] ?></p>
                                    </td>
                                    <td>
                                        <div class="ratio ratio-16x9 border rounded">
                                            <img src="../assets/upload/<?= $images[0]["img"] ?>" class="img-fluid" alt="">
                                        </div>
                                    </td>

                                    <td>
                                        <h6 class="mb-0 text-sm text-center text-truncate"><?= $row["name"] ?></h6>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0 "><?= $row["category_name"] ?></p>
                                    </td>
                                    <td>
                                        <div class="row gap-2 flex-wrap">
                                            <?php foreach ($bands as $band): ?>
                                                <div class="col-auto d-flex justify-content-center">
                                                    <p class="text-center text-xs font-weight-bold mb-0 "><?= $band["band"] ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-2"><?= $date_start ?></p>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?= $date_end ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-2"><?= $sign_up_start ?></p>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?= $sign_up_end ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?= $row["ticket_num"] ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0">
                                            <?php echo $row["ticket_price"] > 0 ? "$" . $row["ticket_price"] : "免費入場"; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0 text-truncate"><?= $row["description"] ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?= $row["city_name"] ?></p>
                                    </td>

                                    <td class="align-middle justify-content-center">
                                        <a class="text-secondary text-sm fw-bold opacity-7" href="?page=2&id=<?= $row["id"] ?>">
                                            <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- pages -->
            <div class="d-flex justify-content-center">
                <?php
                // 預設為第一頁
                $currentPage = $_GET["p"] ?? 1;
                ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php $total_page = ceil($rows["num_rows"]/$per_page);

                        for ($i = 1; $i <= $total_page; $i++): ?>
                            <li class="page-item <?php if ($i == $currentPage) echo "active"; ?>">
                                <a
                                    class="page-link
                                    <?php if ($i == $currentPage) {
                                        echo 'bg-dark text-white';
                                    } else {
                                        echo 'bg-white text-dark';
                                    } ?>"
                                    style="border-color: transparent;"
                                    href="<?= $condition1 ?>&p=<?= $i ?><?=$condition2?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</div>
<?php
$current_page = basename($_SERVER['PHP_SELF']); // 獲取當前頁面的文件名，確保只有當前選中的欄位背景變成黑色，而其他欄位保持原樣
?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
  id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="">
      <img src="download.jpeg" class="navbar-brand-img h-100" alt="">
      <span class="ms-1 fs-5 fw-light">StringVibes</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?= $current_page == 'users.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="/topic/users/pages/users.php">
          <i class="material-symbols-rounded opacity-5  me-1">group</i>
          <span class="nav-link-text ms-1">會員管理</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $current_page == 'product-list.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="/topic/project_product/pages/product-list.php">
          <i class="material-symbols-rounded opacity-5  me-1">inventory_2</i>
          <span class="nav-link-text ms-1">商品管理</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $current_page == 'article.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="/topic/article/pages/article.php">
          <i class="material-symbols-rounded opacity-5  me-1">article</i>
          <span class="nav-link-text ms-1">文章專欄管理</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $current_page == 'band.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="/topic/bandroom/pages/band.php">
          <i class="material-symbols-rounded opacity-5  me-1">music_note</i>
          <span class="nav-link-text ms-1">練團室租借管理</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $current_page == 'coupons.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="/topic/coupon/pages/coupons.php">
          <i class="material-symbols-rounded opacity-5  me-1">confirmation_number</i>
          <span class="nav-link-text ms-1">優惠券管理</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $current_page == 'activity-index.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="/topic/activity/pages/activity-index.php">
          <i class="material-symbols-rounded opacity-5 me-1">theater_comedy</i>
          <span class="nav-link-text ms-1">活動管理</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" href="/topic/users/pages/sign-in.php">
          <i class="material-symbols-rounded opacity-5  me-1">logout</i>
          <span class="nav-link-text ms-1">登出</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link text-dark" href="/users/pages/sign-up.php">
          <i class="material-symbols-rounded opacity-5  me-1">assignment</i>
          <span class="nav-link-text ms-1">註冊</span>
        </a>
      </li> -->
    </ul>
  </div>
  <!-- Add your sidebar content here -->
</aside>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  exit("請循正常管道進入此頁");
}

require_once("../../db_connect.php");

// 設定最大錯誤次數
$max_attempts = 3;

// 初始化錯誤次數
if (!isset($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = 0;
}

$account = $_POST["account"];
$password = $_POST["password"];

// 檢查帳號和密碼是否為空
if (empty($account)) {
  $error = "請輸入帳號";
  header("Location: sign-in.php?error=" . urlencode($error));
  exit();
}

if (empty($password)) {
  $error = "請輸入密碼";
  header("Location: sign-in.php?error=" . urlencode($error));
  exit();
}

// 將密碼進行 MD5 哈希
// $password = md5($password);

// 執行 SQL 查詢
$sql = "SELECT * FROM users WHERE account='$account' AND password='$password' AND is_deleted=0";
$result = $conn->query($sql);

if ($result === false) {
  error_log("SQL Error: " . $conn->error);
  $error = "系統錯誤，請稍後再試";
  header("Location: sign-in.php?error=" . urlencode($error));
  exit();
}

if ($result->num_rows > 0) {
  // 登入成功，重置錯誤次數
  $_SESSION['login_attempts'] = 0;
  header("Location: users.php");
  exit();
} else {
  // 登入失敗，增加錯誤次數
  $_SESSION['login_attempts'] += 1;

  if ($_SESSION['login_attempts'] >= $max_attempts) {
    $error = "輸入錯誤次數過多，請稍後再試。";
  } else {
    $error = "帳號或密碼錯誤";
  }

  header("Location: sign-in.php?error=" . urlencode($error));
  exit();
}

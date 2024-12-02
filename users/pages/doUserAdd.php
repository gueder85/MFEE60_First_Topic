<?php
require_once("../../db_connect.php");// 確認路徑是否正確

// 檢查表單是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $account = $_POST["account"];
  $password = $_POST["password"];
  $gender = $_POST["gender"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $city = $_POST["city"];
  $user_level_id = $_POST["user_level_id"];

  // 插入新使用者到資料庫
  $sql = "INSERT INTO users (name, account, password, gender, email, phone, city, user_level_id, is_deleted) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
  $stmt = $conn->prepare($sql);

  if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
  }

  // 確保類型定義字符串與變數數量和類型匹配
  $stmt->bind_param("sssssss", $name, $account, $gender, $email, $phone, $city, $user_level_id);

  if ($stmt->execute()) {
    // 插入成功，重定向到使用者列表頁面
    header("Location: users.php");
    exit();
  } else {
    // 插入失敗，顯示錯誤訊息
    $error_message = "新增使用者失敗：" . $stmt->error;
  }

  $stmt->close();
}

$conn->close();

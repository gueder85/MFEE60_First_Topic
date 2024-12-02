<?php
require_once("../../db_connect.php");

// 檢查表單是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $password = $_POST["password"];
  $account = $_POST["account"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $city = $_POST["city"];
  $gender = $_POST["gender"];
  $user_level_id = $_POST["user_level_id"];
  $created_at = date("Y-m-d H:i:s");
  $updated_at = date("Y-m-d H:i:s");

  // 插入新使用者到資料庫
  $sql = "INSERT INTO users (name, account, password, email, phone, city, gender, user_level_id, is_deleted, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssssss", $name, $account, $password, $email, $phone, $city, $gender, $user_level_id, $created_at, $updated_at);

  if ($stmt->execute()) {
    // 插入成功，重定向到使用者列表頁面
    header("Location: users.php");
    exit();
  } else {
    // 插入失敗，顯示錯誤訊息
    $error_message = "新增使用者失敗：" . $stmt->error;
    echo $error_message;
  }

  $stmt->close();
}

$conn->close();

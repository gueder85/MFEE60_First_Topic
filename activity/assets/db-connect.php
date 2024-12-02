<?php

$servername = "localhost";
// $username = "root";
$username = "admin";
$password = "0105";
$dbname = "project";

// 建立資料庫連線
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("資料庫連線失敗: " . $conn->connect_error);
}
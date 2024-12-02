<?php
//php連接資料庫

$servername = "localhost";
$username = "evelyn";
$password = "168168";
$dbname = "product_db";  //連到哪個資料庫

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  	die("連線失敗: " . $conn->connect_error); 
}else{
    // echo "連線成功";
}
//exit;

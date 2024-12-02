<?php




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "topics";



//Create connection
$conn = new mysqli($servername, $username,$password, $dbname);
//檢查連線
if($conn ->connect_errno) {
    die("連線失敗: ".$conn->connect_errno);
}else{
    // echo "連線成功";
}
// exit;
// session_start();
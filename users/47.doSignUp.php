<?php
require_once("../26.db_connect.php");

if(!isset($_POST["account"])){
    exit("請依正常管道進入");
}

$account=$_POST["account"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];

if(empty($account)){
    exit("請輸入帳號");
}

$sqlCheck="SELECT * FROM users WHERE account='$account'";
$resultCheck=$conn->query($sqlCheck);
if($resultCheck->num_rows>0){
    exit("帳號已存在");
}

if(empty($password)){
    exit("請輸入密碼");
}

if(($password != $repassword)){
    exit("前後密碼不一致");
}

$password=md5($password);
$now=date('Y-m-d H:i:s');

$sql="INSERT INTO users (account, password, created_at) VALUES ('$account', '$password', '$now') ";

if ($conn->query($sql) === TRUE) {
    $last_id=$conn->insert_id;
    echo "新資料輸入成功,id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location: 46.sign-up.php");
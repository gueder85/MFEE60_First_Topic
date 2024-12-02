<?php
require("../26.db_connect.php");

$name=$_POST["name"];
$account=$_POST["name"];
$password=$_POST["password"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$now=date('Y-m-d H:i:s');
// echo "$name, $email, $phone";

$password=md5($password);

$sql="INSERT INTO users (name, phone, email, created_at, account, password)
	VALUES ('$name', '$phone', '$email', '$now', '$account', '$password')";
// echo $sql;

if ($conn->query($sql) === TRUE) {
    $last_id=$con->insert_id;
    echo "新資料輸入成功,id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: 33.create-user.php");
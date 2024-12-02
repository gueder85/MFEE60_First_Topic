<?php
require_once("../db.php");


$id=$_GET["id"];
$sql="UPDATE  band  SET is_deleted=1 WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
$conn->close();
header("Location: band.php");
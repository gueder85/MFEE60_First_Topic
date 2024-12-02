<?php
require_once("../assets/sqls-activity.php");

$id = $_GET["id"];

$sql = "UPDATE 
            activity
        SET 
            is_deleted = 1
        WHERE 
            id = '$id'";


if ($conn->query($sql) === TRUE) {
    echo "活動刪除成功<br>";
} else {
    echo "活動刪除錯誤: " . $conn->error;
}

$conn->close();

header("Location: activity-index.php");
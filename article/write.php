<?php
require_once("./db_connect.php");

$sql = "INSERT INTO article (title, author, created_at,) VALUES
('他們說我是沒有用的年輕人？——好樂團首張專輯《在遊蕩的路上學會寬容》', '吳亭諺', '2022/12/5');";

if ($conn->query($sql) === TRUE) {
    echo "資料新增成功";
} else {
    echo "新增失敗: " . $conn->error;
}

$conn->close();
?>

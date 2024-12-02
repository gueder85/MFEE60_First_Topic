<?php
require_once("../db_connect.php");

if (!isset($_POST["id"])) {
    exit("請循正常管道進入此頁");
}

$id = $_POST["id"];
$title = $_POST["title"];
$author = $_POST["author"];
$created_at = $_POST["created_at"]; // 從表單接收日期值
$content = $_POST["content"];


// 更新 SQL，將 created_at 加入更新欄位
$sql = "UPDATE article 
        SET content='$content', 
            title='$title', 
            author='$author', 
            created_at='$created_at' 
        WHERE id=$id";

// 執行 SQL 更新
if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

// 關閉連線
$conn->close();

// 重導回修改頁面
header("Location: edit-article.php?id=$id");
exit;
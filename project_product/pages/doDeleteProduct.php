<?php
require_once("../../db_connect.php");

$id = $_GET["id"];

// 同時更新product, product_color, images 的 is_deleted = 1 
try {
    // 開始事務
    $conn->begin_transaction();

    // 第一個 SQL 操作
    $sql1 = "UPDATE product SET is_deleted = 1 WHERE id='$id'";
    $conn->query($sql1);

    // 第二個 SQL 操作
    $sql2 = "UPDATE product_color SET is_deleted = 1 WHERE product_id='$id'";
    $conn->query($sql2);

    // 第三個 SQL 操作
    $sql3 = "UPDATE images SET is_deleted = 1 WHERE product_id='$id'";
    $conn->query($sql3);

    // 如果所有操作都成功，提交事務
    $conn->commit();

} catch (Exception $e) {
    // 如果發生任何錯誤，回滾所有操作
    $conn->rollback();

    // 記錄錯誤或顯示錯誤訊息
    echo "操作失敗：" . $e->getMessage();
}


// if ($conn->query($sql) === TRUE) {
//     echo "刪除成功";
// } else {
//     echo "刪除資料錯誤: " . $conn->error;
// }

$conn->close();

header("location: product-list.php");
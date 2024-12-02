<?php
require_once("../../db_connect.php");

if(!isset($_POST["name"])){
    exit("請循正常管道進入此頁");
}

$id = $_POST["id"];
$name = $_POST["name"];
$brand = $_POST["brand"];
$color = $_POST["color"];
$spec = $_POST["spec"];
$price = $_POST["price"];
$discription = $_POST["discription"];
$main_image_id = $_POST["main_image_id"];

$now = date('Y-m-d H:i:s');

// 更新資料到product
$sql = "UPDATE product SET name='$name', brand_id='$brand', spec='$spec', price='$price', discription='$discription', last_updated='$now' 
WHERE id = $id AND is_deleted=0";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

// 更新資料到product_color
$sql2 = "UPDATE product_color SET color_id='$color'
WHERE product_color.product_id = $id";
$result2=$conn->query($sql2);

if ($conn->query($sql2) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

//更新圖片:
// 查詢原有的圖片資訊
$sqlOldImage = "SELECT image FROM images WHERE product_id = '$id' AND id = '$main_image_id'";
$resultOldImage = $conn->query($sqlOldImage);
$oldImageRow = $resultOldImage->fetch_assoc();
$oldImageName = $oldImageRow['image'];

// 刪除舊圖片檔案
if (!empty($oldImageName) && file_exists("../product_upload/$oldImageName")) {
    unlink("../product_upload/$oldImageName");
}

// 上傳新圖片
if ($_FILES["myFile"]["error"] == 0) {
    $imageName = time(); // 時間戳記
    $extension = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION); // 取得副檔名
    $imageName = $imageName . ".$extension";

    if (move_uploaded_file($_FILES["myFile"]["tmp_name"], "../product_upload/$imageName")) {
        // 更新 images 資料表
        $now = date('Y-m-d H:i:s');
        $sqlUpdateImage = "UPDATE images SET 
                           name = ?, 
                           image = ?, 
                           created_at = ? 
                           WHERE product_id = ? AND id = ?";
        
        $stmt = $conn->prepare($sqlUpdateImage);
        $stmt->bind_param("sssii", $name, $imageName, $now, $id, $main_image_id);
        
        if ($stmt->execute()) {
            echo "圖片資訊更新成功";
        } else {
            echo "圖片資訊更新失敗: " . $stmt->error;
            exit;
        }
        $stmt->close();
    } else {
        echo "圖片上傳失敗";
        exit;
    }
}
// $stmt->close();

$conn->close();

header("location: product-list.php");
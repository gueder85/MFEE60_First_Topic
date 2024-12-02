<?php
require_once("../assets/sqls-activity.php");
require_once("../assets/function.php");

// Activity
$id = $_POST["id"];
$name = $_POST["name"];
$category_id = $_POST["cate"];
$date_start = $_POST["date_start"];
$date_end = $_POST["date_end"];
$sign_up_start = $_POST["sign_up_start"];
$sign_up_end = $_POST["sign_up_end"];
$ticket_num = $_POST["ticket_num"];
$ticket_price = $_POST["ticket_price"];
$description = $_POST["description"];
$address = $_POST["address"];
$city_id = $_POST["city"];

$sql = "UPDATE 
            activity 
        SET 
            name = '$name',
            category_id = '$category_id',
            date_start = '$date_start',
            date_end = '$date_end',
            sign_up_start = '$sign_up_start',
            sign_up_end = '$sign_up_end',
            ticket_num = '$ticket_num',
            ticket_price = '$ticket_price',
            description = '$description',
            address = '$address',
            city_id = '$city_id'
        WHERE 
            id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "活動更新成功<br>";
} else {
    echo "活動更新錯誤: " . $conn->error;
}

// Activty Media 多圖上傳
UploadImage($id);

// Activity_media : 刪除點選的照片
if (isset($_POST['deleteCheck'])) {
    $selectedIds = array_keys($_POST['deleteCheck']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($selectedIds as $id) {
            $sql = "UPDATE 
                    activity_media 
                SET 
                    is_deleted = 1 
                WHERE 
                    id = '$id'";

            if ($conn->query($sql) === TRUE) {
                echo "照片 ID: $id 更新成功<br>";
            } else {
                echo "照片 ID: $id 更新錯誤: " . $conn->error . "<br>";
            }
        }
    }
}

// Activity_band 增加、修改、刪除
$bands = $_POST['bands'];
bandsUpdate($id, $bands);

$conn->close();

header("Location: activity-index.php");

<?php
require_once("../assets/sqls-activity.php");
require_once("../assets/function.php");

// Activity
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

$sql = "INSERT INTO activity (
    name, 
    category_id, 
    date_start, 
    date_end, 
    sign_up_start, 
    sign_up_end, 
    ticket_num, 
    ticket_price, 
    description, 
    address, 
    city_id
) VALUES (
    '$name', 
    '$category_id', 
    '$date_start', 
    '$date_end', 
    '$sign_up_start', 
    '$sign_up_end', 
    '$ticket_num', 
    '$ticket_price', 
    '$description', 
    '$address', 
    '$city_id'
)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id: $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Activity_media 上傳圖片
UploadImage($last_id);

// Activity_band 增加、修改、刪除
$bands = $_POST['bands'];
bandsUpdate($last_id, $bands);


$conn->close();

header("Location: activity-index.php");

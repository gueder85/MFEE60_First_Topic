<?php
require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    exit("請循正常管道進入此頁");
}

$name = $_POST["name"];
$brand = $_POST["brand"];
$color = $_POST["color"];
$spec = $_POST["spec"];
$price = $_POST["price"];
$discription = $_POST["discription"];

$now = date('Y-m-d H:i:s');

// 檢查商品已存在
$sqlCheck = "SELECT product.name FROM product WHERE name='$name' AND is_deleted=0";
$resultCheck = $conn->query($sqlCheck);
if ($resultCheck->num_rows > 0) {
    exit("商品已存在");
}

// 輸入資料到product
$sql = "INSERT INTO product (name, brand_id, spec, price, discription, last_updated) VALUES ('$name', '$brand', '$spec', '$price', '$discription', '$now')";


if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id為 $last_id";

    // // 輸入資料到product_color
    // $sql2 = "INSERT INTO product_color (product_id, color_id) VALUES ($last_id, $color)";
    // $result2 = $conn->query($sql2);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 輸入資料到product_color
$sql2 = "INSERT INTO product_color (product_id, color_id) VALUES ($last_id, $color)";
if ($conn->query($sql2) === TRUE) {
    echo "新資料輸入成功, product_id為 $last_id; color_id為$color";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//輸入圖片到upload資料夾
if ($_FILES["myFile"]["error"] == 0) {

    $imageName = time(); //時間戳記
    $extension = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION); //取得副檔名
    $imageName = $imageName . ".$extension";

    if (move_uploaded_file($_FILES["myFile"]["tmp_name"], "../product_upload/$imageName")) {
        echo "Upload success!<br>";
    } else {
        echo "Upload fail!<br>";
    }
} else {
    var_dump($_FILES["myFile"]["error"]);
    exit;
}

//輸入圖片資訊到images
$now = date('Y-m-d H:i:s');
$sqlImg = "INSERT INTO images (product_id, name, image, created_at) VALUES ('$last_id', '$name', '$imageName', '$now')";

if ($conn->query($sqlImg) === TRUE) {
    $last_img_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_img_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit;
}

//輸入images.id到product.main_image_id
$sqlToPdImg = "UPDATE product SET main_image_id='$last_img_id' WHERE id = $last_id";
$resultToPdImg=$conn->query($sqlToPdImg);

$conn->close();
header("location: product-list.php");

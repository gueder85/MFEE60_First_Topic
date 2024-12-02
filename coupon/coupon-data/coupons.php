<?php
require_once("../../db_connect.php");





$type = $_POST["category_id"];
$name = $_POST["name"];
$discount_type=$_POST["discount_type"];
$discount = $_POST["discount"];
$str_time = $_POST["str-time"];
$end_time = $_POST["end-time"];

if ($name === "") {
    echo "建立失敗: 請輸入優惠券名稱";
    exit;
} else {
    echo "建立成功<br>";
}
$sql = "SELECT * FROM coupons_type
WHERE coupons_type.id = $type
";
$result = $conn->query($sql);
$resulttype = $result->fetch_all(MYSQLI_ASSOC);
// print_r($resulttype); 檢查陣列
$select = $resulttype[0]["category"]; //這是一個二維陣列 需要兩個值

echo "$select<br>";
echo " $name<br>";
echo " $discount_type<br>";
echo " $discount<br>";
echo "$str_time<br>";
echo "$end_time<br>";

$sql = "INSERT INTO coupons (name, type, discount, str_time, end_time)
VALUES ('$name', '$select', '$discount', '$str_time','$end_time')
";

if ($conn->query($sql) === TRUE) {
    echo "建立成功<br>";
    header("location: ../pages/coupons.php");
    // exit;
}else{
    echo "建立失敗: 資料庫錯誤 - " . $conn->error;
}

$conn->close();

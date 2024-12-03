<?php
require_once("../../db_connect.php");





$type = $_POST["category_id"];
$name = $_POST["name"];
$discount_type=$_POST["discount_type"];
$discount = $_POST["discount"];
$str_time = $_POST["str-time"];
$end_time = $_POST["end-time"];

// $variables = [
//     'name' => $_POST['name'],
//     'type' => $_POST['category_id'],
//     'discount' => $_POST['discount'],
//     'str_time' => $_POST['str-time'],
//     'end_time' => $_POST['end-time'],
//     'discount_type' => $_POST['discount_type'],
// ];

// $fieldNames = [
//     'name' => '名稱',
//     'type' => '類型',
//     'discount' => '折扣',
//     'str_time' => '開始日期',
//     'end_time' => '結束日期',
//     'discount_type' => '折扣類型',
// ];

// foreach ($variables as $fieldName => $value) {
//     if (empty($value)) {
//         echo json_encode(['status' => 0, 'message' => "請輸入{$fieldNames[$fieldName]} "]);
//     }
//     exit;

// }

//輸入欄位檢查
function checkEmptyAndReturnJson($variable, $fieldName){
    if (empty($variable)) {
        // return json_encode(['status' => 0, 'message' => "請輸入{$fieldName} "]);
        return ["欄位"=>$fieldName,"訊息"=>"請輸入{$fieldName}"];
    }
    return null;
}
$errors = [];

$errors[] = checkEmptyAndReturnJson($name, '名稱');
$errors[] = checkEmptyAndReturnJson($type, '類型');
$errors[] = checkEmptyAndReturnJson($discount, '折扣');
$errors[] = checkEmptyAndReturnJson($str_time, '開始日期');
$errors[] = checkEmptyAndReturnJson($end_time, '結束日期');
$errors[] = checkEmptyAndReturnJson($discount_type, '折扣類型');
$errors = array_filter($errors); //移除空值

if (!empty($errors)) {
    $data = ['status' => 0, 'errors' => $errors];
    echo json_encode($data);
    exit;
}
// 檢查完畢


$sql = "SELECT * FROM coupons_type
WHERE coupons_type.id = $type
";
$result = $conn->query($sql);
$resulttype = $result->fetch_all(MYSQLI_ASSOC);
// print_r($resulttype); 檢查陣列
$select = $resulttype[0]["category"]; //這是一個二維陣列 需要兩個值

echo " $name<br>";
echo "$select<br>";
echo " $discount_type<br>";
echo " $discount<br>";
echo "$str_time<br>";
echo "$end_time<br>";

$sql = "INSERT INTO coupons (name, type,discount_type , discount, str_time, end_time)
VALUES ('$name','$select', '$discount_type', '$discount', '$str_time','$end_time')
";

if ($conn->query($sql) === TRUE) {
    echo "建立成功<br>";
    header("location: ../pages/coupons.php");
    // exit;
}else{
    echo "建立失敗: 資料庫錯誤 - " . $conn->error;
}

$conn->close();

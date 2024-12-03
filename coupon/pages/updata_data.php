<?php
require_once("../../db_connect.php");
//coupons_select



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $type = $_POST["type"];
    $discount_type = $_POST["discount_type"];
    $discount = $_POST["discount"];
    $str_time = $_POST["str-time"];
    $end_time = $_POST["end-time"];
    $status = "success";
    $result = new stdClass();
    $result->id = $id;
    $result->name = $name;
    $result->type = $type;
    $result->discount_type = $discount_type;
    $result->discount = $discount;
    $result->str_time = $str_time;
    $result->end_time = $end_time;
    $result->success = $status;
    $seleSql = "SELECT * FROM coupons_select ";
    $resultSelect = $conn->query($seleSql);
    $selects = $resultSelect->fetch_all(MYSQLI_ASSOC);
    $selectsArr = [];
    foreach ($selects as $select) {
        $selectsArr[$select["id"]] = $select["name"];
    }
    // End--coupons_select--
    
    header('Content-Type: application/json; charset=utf-8');

    //輸入欄位檢查
    function checkEmptyAndReturnJson($value, $fieldName) {
        if (empty($value)) {
            return ["欄位" => $fieldName, "訊息" => "請輸入{$fieldName}"];
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
            echo json_encode($data , JSON_UNESCAPED_UNICODE); // 使用 JSON_UNESCAPED_UNICODE 選項處理 Unicode 字元
            exit;
        }
    //檢查完畢

    echo json_encode($result);
    $sql = "UPDATE coupons SET name='$name', type='$type',discount_type ='$discount_type',discount='$discount', str_time='$str_time', end_time='$end_time' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT * FROM coupons WHERE id = $id";
        $result2 = $conn->query($sql);
        $results = $result2->fetch_all(MYSQLI_ASSOC);
        echo json_encode($results);
        echo "更新成功";
    } else {
        echo "更新資料錯誤:" . $conn->error;
    }

    $conn->close();
    // header("Location: coupons.php");
}

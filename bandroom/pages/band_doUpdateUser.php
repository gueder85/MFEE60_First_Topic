<?php
require_once("../db.php");

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 调试输出 POST 数据
    echo "<pre>";
    print_r($_POST);  // 打印所有 POST 数据，查看 'area' 是否存在
    echo "</pre>";

    // 获取 POST 数据
    $id = $_POST["id"];
    $name = $_POST["name"];
    
    // 检查 area 是否存在
    if (isset($_POST['area']) && !empty($_POST['area'])) {
        $area = $_POST['area'];
    } else {
        die("请选择一个区域！");  // 如果没有选择区域，终止执行
    }

    $information = $_POST["information"];
    $price = $_POST["price"];

    // 处理图片上传
    $img = $_FILES["img"];
    $newImgName = null;

    // 如果用户上传了新图片
    if (isset($img) && $img["error"] == 0) {
        // 设置图片上传目录
        $targetDir = "../img/";

        // 如果目录不存在，创建目录
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // 生成新的图片名称（使用当前日期时间作文件名）
        $imageFileType = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
        $newImgName = date("Y-m-d_His") . "." . $imageFileType;  // 格式：2024-11-29_123456.jpg

        // 图片的上传路径
        $targetFile = $targetDir . $newImgName;

        // 上传文件
        if (move_uploaded_file($img["tmp_name"], $targetFile)) {
            echo "图片上传成功！<br>";
        } else {
            echo "图片上传失败！<br>";
            $newImgName = null;  // 上传失败时，不更新图片
        }
    }

    // 更新数据库的 SQL 语句
    if ($newImgName) {
        // 如果有新图片，更新图片路径
        $sql = "UPDATE band SET name='$name', area='$area', information='$information', price='$price', img='$newImgName' WHERE id=$id";
    } else {
        // 如果没有上传新图片，仅更新其他字段
        $sql = "UPDATE band SET name='$name', area='$area', information='$information', price='$price' WHERE id=$id";
    }

    // 执行 SQL 查询
    if ($conn->query($sql) === TRUE) {
        echo "更新成功！";
    } else {
        echo "更新资料错误: " . $conn->error;
    }

    $conn->close();

    // 重定向回列表页面
    header("location: band_porduct.php?id=$id");
}
?>

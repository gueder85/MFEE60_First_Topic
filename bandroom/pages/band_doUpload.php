<?php
require_once("../db.php");

// 處理表單數據
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $area_id = $_POST['area_id'];
    $area = $_POST['area'];
    $information = $_POST['information'];
    $price = $_POST['price'];
    $img = $_FILES['img'];
    $now = date("Y-m-d H:i:s");  // 當前時間

    // 檢查是否有上傳圖片
    if (isset($img) && $img["error"] == 0) {
        // 設定圖片上傳目錄為相對路徑
        $targetDir = "../img/";  // 改為相對路徑到根目錄下的 img 資料夾
        
        // 檢查目錄是否存在，如果不存在，則創建
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);  // 創建目錄並設置權限
        }

        // 生成新的圖片名稱（使用當前日期時間作為檔名）
        $imageFileType = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
        $newFileName = date("Y-m-d_His") . "." . $imageFileType;  // 格式：2024-11-29_123456.jpg

        $targetFile = $targetDir . $newFileName;
        $uploadOk = 1;

        // 檢查是否為圖片
        if (getimagesize($img["tmp_name"]) === false) {
            echo "檔案不是圖片。";
            $uploadOk = 0;
        }

        // 檢查檔案大小（例如限制在 5MB 以內）
        if ($img["size"] > 5000000) {
            echo "檔案太大。";
            $uploadOk = 0;
        }

        // 只允許特定格式的圖片
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            echo "只允許 JPG, JPEG, PNG, GIF 格式的圖片。";
            $uploadOk = 0;
        }

        // 如果圖片檢查通過，則嘗試上傳
        if ($uploadOk == 1) {
            if (move_uploaded_file($img["tmp_name"], $targetFile)) {
                // 圖片上傳成功，使用預處理語句將資料插入資料庫
                $stmt = $conn->prepare("INSERT INTO band (name, area_id, area, information, price, img, created_at) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $name, $area_id, $area, $information, $price, $newFileName, $now);

                // 執行查詢
                if ($stmt->execute()) {
                    echo "資料成功上傳！";
                } else {
                    echo "SQL 錯誤: " . $stmt->error;  // 顯示具體錯誤
                }

                $stmt->close();
            } else {
                echo "圖片上傳失敗。";
            }
        } else {
            echo "檔案無效或格式不正確，請重試。";
        }
    } else {
        echo "圖片未上傳或上傳錯誤。";
    }
}

// 關閉資料庫連接
$conn->close();
header("location: band_upload.php");

?>

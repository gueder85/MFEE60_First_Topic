<?php
require_once("../../db_connect.php");


function UploadImage($id)
{
    global $conn;

    // $_FILES["file"]["name"][] 檔名陣列
    // $_FILES["file"]["error"][] 錯誤陣列
    if (isset($_FILES["file"])) {
        foreach ($_FILES["file"]["error"] as $key => $error) {
            if ($error == 0) {
                // 檔案
                $file = $_FILES["file"]["name"][$key];
                // 檔名
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                // 副檔名
                $extension = pathinfo($file, PATHINFO_EXTENSION);

                $uploadFile = $fileName . "_" . time() . "." . $extension;

                if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], "../assets/upload/$uploadFile")) {
                    echo "照片上傳成功<br>";
                } else {
                    echo "照片上傳失敗<br>";
                }

                $sql = "INSERT INTO Activity_media 
                            (activity_id, img) 
                        VALUES 
                            ('$id', '$uploadFile')";

                if ($conn->query($sql) === TRUE) {
                    echo "照片 " . $uploadFile . " 寫入成功<br>";
                } else {
                    echo "照片寫入失敗: " . $conn->error;
                }
            }
        }
    }
}

function bandsUpdate($id, $bands) {
    global $conn;

    foreach ($bands as $band_id => $band) {
        // band 欄位不為空
        if (!empty($band)) {
            // 檢查 band 是否存在
            $checkSql = "SELECT id FROM activity_band WHERE activity_id = '$id' AND band = '$band'";
            $result = $conn->query($checkSql);

            // 若存在則更新 band
            if ($result->num_rows > 0) {
                $sql = "UPDATE 
                            activity_band
                        SET 
                            band = '$band'
                        WHERE 
                            id = '$band_id'";
            }
            // 否則插入新的 band
            else {
                $sql = "INSERT INTO activity_band 
                            (activity_id, band)
                        VALUES 
                            ('$id', '$band')";
            }
        }

        // 如果 band 欄位為空，則刪除  
        else {
            $sql = "DELETE FROM
                        activity_band 
                    WHERE 
                        id = '$band_id'";
        }

        if ($conn->query($sql) === TRUE) {
            echo "id: $band_id, band: $band, 放入活動: $id <br>";
        } else {
            echo "樂團更新錯誤: " . $conn->error;
        }
    }
}

<?php
require_once("../26.db_connect.php");

if(!isset($_POST["name"])){
    exit("請循正常管道進入此頁");
}

$name=$_POST["name"];

if($_FILES["myFile"]["error"]==0){

    // $imageName="../upload/".$_FILES["myFile"]["name"];
    $imageName=time();
    $extName=pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
    $imageName=$imageName.".$extName";

    if(move_uploaded_file($_FILES["myFile"]["tmp_name"],"../upload/$imageName")){
        echo "Upload success!<br>";
    }else{
        echo "Upload fail!<br>";
    }
}else{
    var_dump($_FILES["myFile"]["error"]);
    exit;
}

// echo "end!!";
// $image=$_FILES["myFile"]["name"];
$now=date('Y-m-d H:i:s');
$sql="INSERT INTO images (name, image, created_at) VALUES ('$name', '$imageName', '$now')";
if ($conn->query($sql) === TRUE){
    $last_id=$conn->insert_id;
    echo"新資料輸入成功, id為 $last_id";
}else {
    echo "Error: " .$sql . "<br>" . $conn->error;
    exit;
}


// print_r($_FILES["myFile"]);
$conn->close();
header("location: 74.upload.php");
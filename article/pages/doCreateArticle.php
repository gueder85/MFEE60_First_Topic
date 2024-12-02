<?php
require_once("../db_connect.php");

$title=$_POST["title"];
$author=$_POST["author"];
$created_at=$_POST["created_at"];
$category_id=$_POST["category"];
$content=$_POST["content"];


// if($_FILES["myFile"]["error"]==0){

//     $imageName=time();
//     $extName=pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
//     $imageName=$imageName.".$extName";

//     if(move_uploaded_file($_FILES["myFile"]["tmp_name"],"../img/$imageName")){
//         echo "Upload success!<br>";
//     }else{
//         echo "Upload fail!<br>";
//     }

    
// }

$sql="INSERT INTO article (title, author, created_at, content, category_id)
	VALUES ('$title', '$author', '$created_at', '$content', '$category_id')";

if ($conn->query($sql) === TRUE) {
    $last_id=$conn->insert_id;
    echo "新資料輸入成功,id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

header("Location: article.php");

?>
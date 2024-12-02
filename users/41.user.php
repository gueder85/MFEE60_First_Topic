<?php
require_once("../26.db_connect.php");

if(!isset($_GET["id"])){
    echo "請帶入id到此頁";
    exit;
}
$id=$_GET["id"];

$sql="SELECT * FROM users WHERE id='$id' AND is_deleted=0";

$result=$conn->query($sql);
$row=$result->fetch_assoc();

$sqlLikes="SELECT user_like.*, product.name 
FROM user_like
JOIN product ON user_like.product_id = product.id
WHERE user_like.user_id = $id;
";
$resultLikes=$conn->query($sqlLikes);
$rowsLikes=$resultLikes->fetch_all(MYSQLI_ASSOC);


?>
<!doctype html>
<html lang="en">
    <head>
        <title>User</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <?php include("../css.php") ?>
    </head>

    <body>
        <div class="container">
        <div class="py-2">
                <a class="btn btn-info" href="37.users.php"><i class="fa-solid fa-circle-left fa-fw"></i> 返回使用者列表</a>
            </div>
            <?php if($result->num_rows>0): ?>
                <h1><?=$row["name"]?></h1>
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <td><?=$row["id"]?></td>
                    </tr>
                    <tr>
                        <th>email</th>
                        <td><?=$row["email"]?></td>
                    </tr>
                    <tr>
                        <th>phone</th>
                        <td><?=$row["phone"]?></td>
                    </tr>
                    <tr>
                        <th>created time</th>
                        <td><?=$row["created_at"]?></td>
                    </tr>
                </table>
                <a href="44.user-edit.php?id=<?=$row["id"]?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
                <hr>
                <h2 class="mt-4">收藏商品</h2>
                <?php if($resultLikes->num_rows == 0): ?>
                    尚未收藏商品
                <?php else: ?>
                    <ul>
                        <?php foreach($rowsLikes as $product): ?>
                            <li><a href="/product/product.php?id=<?=$product["product_id"]?>"><?= $product["name"] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php else: ?>
                <h1>找不到使用者</h1>
            <?php endif; ?>
        </div>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>

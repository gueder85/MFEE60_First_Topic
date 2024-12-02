<?php
require_once("../26.db_connect.php");

$per_page = 4;
$sqlALL = "SELECT * FROM users WHERE is_deleted=0";
$resultALL = $conn->query($sqlALL);
$userALLcount = $resultALL->num_rows;

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM users WHERE name LIKE '%$search%' AND is_deleted=0";
} else if (isset($_GET["p"])) {
    $p = $_GET["p"];
    if (!isset($_GET["order"])) {
        header("location: 37.users.php?p=1&order=1");
    }
    $order = $_GET["order"];
    $start_item = ($p - 1) * $per_page;
    $total_page = ceil($userALLcount / $per_page);

    // if ($order == 1) {
    //     $sql = "SELECT * FROM users WHERE is_deleted=0 
    //     ORDER BY id ASC
    //     LIMIT $start_item, $per_page  
    // ";
    // } else if ($order == 2) {
    //     $sql = "SELECT * FROM users WHERE is_deleted=0 
    //     ORDER BY id DESC
    //     LIMIT $start_item, $per_page  
    // ";
    // }
    $whereClause="";
    switch($order){
        case 1:
            $whereClause = "ORDER BY id ASC";
            break;
        case 2:
            $whereClause = "ORDER BY id DESC";
            break;
        case 3:
            $whereClause = "ORDER BY account ASC";
            break; 
        case 4:
            $whereClause = "ORDER BY account DESC";
            break;     
    }

    $sql = "SELECT * FROM users WHERE is_deleted=0 
            $whereClause
            LIMIT $start_item, $per_page";  
} else {
    header("location: 37.users.php?p=1&order=1");
}

$result = $conn->query($sql);
if (isset($_GET["search"])) {
    $user_count = $result->num_rows;
} else {
    $user_count = $userALLcount;
}





$rows = $result->fetch_all(MYSQLI_ASSOC);



?>
<!doctype html>
<html lang="en">

<head>
    <title>users</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <!-- include讀取資源 -->
    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="d-flex py-2 align-items-center">
            <h1>使用者列表</h1>
        </div>

        <div class="py-2 text-end">
            <div class="row g-3 justify-content-between">
                <div class="col-md-6">
                    <form action="" method="get">
                        <div class="input-group">
                            <?php if (isset($_GET["search"])): ?>
                                <a class="btn btn-info" href="37.users.php"><i class="fa-solid fa-circle-left fa-lg"></i></a>
                            <?php endif; ?>
                            <input type="search" class="form-control" name="search" value="<?= $_GET["search"] ?? "" ?>">
                            <button class="btn btn-info" type="submit"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-auto">
                    <a class="btn btn-info" href="33.create-user.php" title="新增使用者"><i class="fa-solid fa-user-plus fa-fw"></i></a>
                </div>
            </div>
        </div>
        <div class="py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>共計<?= $user_count ?>使用者</div>
                <?php if (isset($_GET["p"])): ?>
                
                <?php
                $order=$_GET["order"] ?? "";
                ?>
                <div class="btn-group">
                    <a class="btn btn-info" href="37.users.php?p=<?= $p ?>&order=1"><i class="fa-solid fa-arrow-down-1-9 fa-fw"></i></a>
                    <a class="btn btn-info" href="37.users.php?p=<?= $p ?>&order=2"><i class="fa-solid fa-arrow-down-9-1 fa-fw"></i></a>
                    <a class="btn btn-info" href="37.users.php?p=<?= $p ?>&order=3"><i class="fa-solid fa-arrow-down-a-z fa-fw"></i></a>
                    <a class="btn btn-info" href="37.users.php?p=<?= $p ?>&order=4"><i class="fa-solid fa-arrow-down-z-a fa-fw"></i></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($user_count > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>account</th>
                        <th>name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $user): ?>
                        <tr>
                            <td><?= $user["id"] ?></td>
                            <td><a href="41.user.php?id=<?= $user["id"] ?>"><?= $user["account"] ?></a></td>
                            <td><?= $user["name"] ?></td>
                            <td><?= $user["email"] ?></td>
                            <td><?= $user["phone"] ?></td>
                            <td><a href="44.user-edit.php?id=<?= $user["id"] ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square fa-fw"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (isset($_GET["p"])): ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $total_page; $i++): ?>
                            <li class="page-item 
                            <?php
                            if ($i == $_GET["p"]) echo "active"; ?>">
                                <a class="page-link" href="37.users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            目前沒有使用者
        <?php endif; ?>
    </div>



    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>
<!doctype html>
<html lang="en">
    <head>
        <title>Create User</title>
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
                <a class="btn btn-info" href="37.users.php"><i class="fa-solid fa-circle-left fa-lg"></i> 返回</a>
            </div>
            <h1>新增使用者</h1>
            <form action="34.doCreateUser.php" method="post">
                <div class="mb-2">
                    <label for="" class="form-label">帳號</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="mb-2">
                    <label for="" class="form-label">密碼</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-2">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-2">
                    <label for="" class="form-label">Phone</label>
                    <input type="tel" class="form-control" name="phone">
                </div>
                <button class="btn btn-info" >送出</button>
            </form>
        </div>
    </body>
</html>

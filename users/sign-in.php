<?php
session_start();

if(isset($_SESSION["user"])){
    header("location: dashboard.php");
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Sign in</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        body {
            background: url(../img/bgimg1.jpg) center center / cover;
        }

        /* --------------------------------- */
        .box1 {
            width: 500px;
        }

        .box2 {
            width: 300px;
        }

        .box3 {
            width: 400px;
            height: 500px;
            background: rgba(255, 255, 255, 0.709);
            border-radius: 20px;
        }

        /* --------------------------------- */

        .logo {
            height: 48px;
        }

        /* .input-top {
            border-radius: 10px 10px 0 0;
        }
        .input-bottom {
            border-radius: 0 0 10px 10px;
        } */
        .input-area {

            /* 順序選擇器 :nth-child(?) */
            .form-floating:nth-child(1) {
                .form-control {
                    border-bottom-right-radius: 0;
                    border-bottom-left-radius: 0;
                }
            }

            .form-floating:nth-child(2) {
                /* 用position: relative去重疊中間的線 */
                position: relative;
                top: -1px;

                .form-control {
                    border-top-right-radius: 0;
                    border-top-left-radius: 0;
                }
            }

            /* 用 ":focus" 觸發 "z-index:2" 讓發光顯示正常 */
            .form-control:focus {
                /* #一定要給 "position: relative" */
                position: relative;
                z-index: 2;
            }
        }
    </style>
</head>

<body>
    <!-- -------------------------------------------------------- -->
    <!-- 
    <div class="container flex-wrap box1 p-5">
            <div>
                <img src="../images/Trip.com_logo.svg.png" alt="" class="logo mb-2">
            </div>
            <h3>Please sign in</h3>
            <div class="box2">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating box2">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
            </div>
            <div class="mb-3 mt-3 form-check">
                <input type="checkbox" class="form-check-input " id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
              </div>
            <button type="submit" class="btn btn-primary py-2 w-75">Sign in</button>  

        </div> -->
    <!-- ---------------------------------------------------- -->
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="box3 d-flex justify-content-center align-items-center">
            <div class="box2">
                <img class="logo mb-2 " src="../img/Trip.com_logo.svg.png" alt="">
                <h1 class="h3">會員登入</h1>
                <?php if(isset($_SESSION["error"]["times"]) && $_SESSION["error"]["times"]>5): ?>
                    <h5 class="text-danger">輸入錯誤過多, 請稍後再嘗試</h5>
                <?php else: ?>
                <form action="doSignIn.php" method="post">
                    <div class="input-area">
                        <div class="form-floating">
                            <input type="text" class="form-control input-top" id="floatingInput" name="account">
                            <label for="floatingInput">輸入帳號</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control input-bottom" id="floatingPassword" name="password">
                            <label for="floatingPassword">輸入密碼</label>
                        </div>
                    </div>
                    <div class="my-3 form-check">
                        <input type="checkbox" class="form-check-input " id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <?php if (isset($_SESSION["error"]["message"])): ?>
                        <div class="mb-2 text-danger"><?= $_SESSION["error"]["message"] ?></div>
                    <?php 
                    unset($_SESSION["error"]["message"]);
                    endif; ?>
                    <button type="submit" class="btn btn-primary py-2 w-100">登入</button>
                </form>
                <?php endif; ?>
                <!-- text-muted 變灰 -->
                <p class="mt-5 text-muted">© 2017–2024</p>
            </div>
        </div>
    </div>

    </div>














    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>
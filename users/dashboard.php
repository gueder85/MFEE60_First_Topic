<?php
session_start();

if(!isset($_SESSION["user"])){
  header("location: sign-in.php");
  exit;
}

?>


<!doctype html>
<html lang="en">
    <head>
        <title>Dashboard</title>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            :root {
                --aside-width: 320px;
                --header-height: 50px;
            }
            /* ------------------------------------ */
            .dashboard-logo {
                width: var(--aside-width);
                font-size: 20px;
            }
            .dashboard-aside {
                top: 0;
                width: var(--aside-width);
                padding-top: var(--header-height);
            }
            .sr-font {
                font-size: 12px;
                padding-block: 5px;
                color: grey;
            }
            .main-contenet {
                margin-left: var(--aside-width);
                margin-top: var(--header-height);
            }
        </style>
    </head>

    <body>
        <header class="main-header fixed-top d-flex bg-dark justify-content-between align-items-center ">
            <a class="dashboard-logo link-light text-decoration-none bg-black px-3 py-2 shadow">
                Trip.com
            </a>
            <div class="text-white pe-3">
                Hi, <?=$_SESSION["user"]["name"]?>
                <a class="btn btn-dark" href="doSignOut.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </header>
        <aside class="dashboard-aside position-fixed vh-100 bg-light border-end overflow-auto">
            <ul class="list-unstyled">
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-house fa-fw me-2"></i >Dashboard</a></li>
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-list-check fa-fw me-2"></i>Orders</a></li>
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-cart-shopping fa-fw me-2"></i>Products</a></li>  
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-person fa-fw me-2"></i>Customers</a></li> 
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-flag fa-fw me-2"></i>Reports</a></li>
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-folder-open fa-fw me-2"></i>integrations</a></li>                
            </ul>
            <div class="mt-3 px-3 d-flex justify-content-between">
                <div class="sr-font">SAVED REPORTS</div>
                <!-- role="button" 滑鼠hover會變換指標形狀 -->
                <a role="button"><i class="fa-solid fa-circle-plus"></i></a>
            </div>
            <ul class="list-unstyled">
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-regular fa-file-lines fa-fw me-2"></i>Current month</a></li>  
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-regular fa-file-lines fa-fw me-2"></i>Last quarter</a></li> 
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-regular fa-file-lines fa-fw me-2"></i>Social engagement</a></li>
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-regular fa-file-lines fa-fw me-2"></i>Year-end sale</a></li>    
            </ul>
            <hr>
            <ul class="list-unstyled">
                <li class="py-2 px-3 "><a class="text-decoration-none" href=""><i class="fa-solid fa-gear fa-fw me-2"></i>Setting</a></li>
                <li class="py-2 px-3 "><a class="text-decoration-none" href="doSignOut.php"><i class="fa-solid fa-right-from-bracket fa-fw me-2"></i>Sign out</a></li>   
            </ul>
        </aside>
        <main class="main-contenet p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Dashboard</h1>
                <div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn btn-outline-secondary">Share</div>
                        <div class="btn btn-outline-secondary">Export</div>
                    </div>
                    <div class="btn btn-sm btn-outline-secondary"><i class="fa-regular fa-calendar-days fa-fw pe-1"></i>This week</div>
                </div>
            </div>
            <hr>   
            <h1>Section title</h1>
            <div class="table-responsive small">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Header</th>
                      <th scope="col">Header</th>
                      <th scope="col">Header</th>
                      <th scope="col">Header</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1,001</td>
                      <td>random</td>
                      <td>data</td>
                      <td>placeholder</td>
                      <td>text</td>
                    </tr>
                    <tr>
                      <td>1,002</td>
                      <td>placeholder</td>
                      <td>irrelevant</td>
                      <td>visual</td>
                      <td>layout</td>
                    </tr>
                    <tr>
                      <td>1,003</td>
                      <td>data</td>
                      <td>rich</td>
                      <td>dashboard</td>
                      <td>tabular</td>
                    </tr>
                    <tr>
                      <td>1,003</td>
                      <td>information</td>
                      <td>placeholder</td>
                      <td>illustrative</td>
                      <td>data</td>
                    </tr>
                    <tr>
                      <td>1,004</td>
                      <td>text</td>
                      <td>random</td>
                      <td>layout</td>
                      <td>dashboard</td>
                    </tr>
                    <tr>
                      <td>1,005</td>
                      <td>dashboard</td>
                      <td>irrelevant</td>
                      <td>text</td>
                      <td>placeholder</td>
                    </tr>
                    <tr>
                      <td>1,006</td>
                      <td>dashboard</td>
                      <td>illustrative</td>
                      <td>rich</td>
                      <td>data</td>
                    </tr>
                    <tr>
                      <td>1,007</td>
                      <td>placeholder</td>
                      <td>tabular</td>
                      <td>information</td>
                      <td>irrelevant</td>
                    </tr>
                    <tr>
                      <td>1,008</td>
                      <td>random</td>
                      <td>data</td>
                      <td>placeholder</td>
                      <td>text</td>
                    </tr>
                    <tr>
                      <td>1,009</td>
                      <td>placeholder</td>
                      <td>irrelevant</td>
                      <td>visual</td>
                      <td>layout</td>
                    </tr>
                    <tr>
                      <td>1,010</td>
                      <td>data</td>
                      <td>rich</td>
                      <td>dashboard</td>
                      <td>tabular</td>
                    </tr>
                    <tr>
                      <td>1,011</td>
                      <td>information</td>
                      <td>placeholder</td>
                      <td>illustrative</td>
                      <td>data</td>
                    </tr>
                    <tr>
                      <td>1,012</td>
                      <td>text</td>
                      <td>placeholder</td>
                      <td>layout</td>
                      <td>dashboard</td>
                    </tr>
                    <tr>
                      <td>1,013</td>
                      <td>dashboard</td>
                      <td>irrelevant</td>
                      <td>text</td>
                      <td>visual</td>
                    </tr>
                    <tr>
                      <td>1,014</td>
                      <td>dashboard</td>
                      <td>illustrative</td>
                      <td>rich</td>
                      <td>data</td>
                    </tr>
                    <tr>
                      <td>1,015</td>
                      <td>random</td>
                      <td>tabular</td>
                      <td>information</td>
                      <td>text</td>
                    </tr>
                  </tbody>
                </table>
              </div>       
        </main>







    <!-- --------------------------------- -->
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

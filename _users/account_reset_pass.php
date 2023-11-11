<?php
include('../database/connect.php');
include('handling/handling_account_reset_pass.php');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Your Personal Page</title>

        <link rel="stylesheet" href="../assets/others/vendor/feather/feather.css">
        <link rel="stylesheet" href="../assets/others/vendor/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../assets/others/vendor/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/others/vendor/typicons/typicons.css">
        <link rel="stylesheet" href="../assets/others/vendor/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="../assets/others/vendor/css/vendor.bundle.base.css">

        <link rel="stylesheet" href="../assets/css/users/select.dataTables.min.css">

        <link rel="stylesheet" href="../assets/css/users/account_page.css">
        <link href="../assets/img/others/logo_mini.png" rel="icon">
    </head>
    <body>
        <div class="container-scroller">
            <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                    <div class="me-3">
                        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                            <span class="icon-menu"></span>
                        </button>
                    </div>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-top"> 
                    <ul class="navbar-nav">
                        <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                            <h1 class="welcome-text">Hello, <span class="text-black fw-bold"><?php echo $_SESSION['account_name'] ?></span></h1>
                            <h3 class="welcome-sub-text">How are you doing?</h3>
                        </li>
                    </ul>
                </div>
                <?php
                include('nav_account.php');
                ?>   
                <div class="main-panel">        
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="card">                
                                <div class="card-body ml-5">
                                    <h3 class="card-title form_account">Password</h3>      
                                    <form class="forms-sample" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <div class="row">   
                                            <div class="ml-3 col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input name="current-password" type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputConfirmPassword1">New password</label>
                                                    <input name="new-password" type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputConfirmPassword1">Re-password</label>
                                                    <input name="verify-password" type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                                                </div>
                                            </div>  
                                        </div>
                                        <button name="update_pass" type="submit" class="btn btn-primary me-2">Submit</button>
                                    </form>
                                </div>
                            </div>      
                        </div>
                        <footer class="footer">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">From <a href="https://www.bootstrapdash.com/" target="_blank">MEOW SHOP</a> with love</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2022</span>
                            </div>
                        </footer>
                        <!-- partial -->
                    </div>
                    <!-- main-panel ends -->
                </div>
                <!-- page-body-wrapper ends -->
        </div>

        <script src="../assets/others/vendor/js/vendor.bundle.base.js"></script>

        <script src="../assets/others/vendor/chart.js/Chart.min.js"></script>
        <script src="../assets/others/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="../assets/others/vendor/progressbar.js/progressbar.min.js"></script>

        <script src="../assets/js/off-canvas.js"></script>
        <script src="../assets/js/hoverable-collapse.js"></script>
        <script src="../assets/js/template.js"></script>
        <script src="../assets/js/settings.js"></script>
        <script src="../assets/js/todolist.js"></script>

        <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
        <script src="../assets/js/dashboard.js"></script>
        <script src="../assets/js/Chart.roundedBarCharts.js"></script>
    </body>
</html>


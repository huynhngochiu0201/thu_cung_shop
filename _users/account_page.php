<?php
include('../database/connect.php');
include('handling/handling_account_page.php');
if (!isset($_SESSION['account_id'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
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
                <!-- partial -->     
                <div class="main-panel">        
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="card">                
                                <div class="card-body ml-5">
                                    <h3 class="card-title form_account">Information Account</h3>      
                                    <form class="forms-sample" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                        <?php
                                        //take account
                                        $infor_account = "account_name, date_of_birth, account_address, gender, phone, avatar, customer_bio";
                                        $query_account = mysqli_query($con, "SELECT $infor_account FROM accounts, customers WHERE accounts.account_id=customers.account_id AND accounts.account_id=" . $_SESSION['account_id'] . ";");
                                        while ($row = mysqli_fetch_array($query_account)) {
                                            ?>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Username</label>
                                                        <input name="account_name" value="<?php echo htmlentities($row['account_name']); ?>" type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputAddress">Address</label>
                                                        <input name="account_address" value="<?php echo htmlentities($row['account_address']); ?>" type="text" class="form-control" id="exampleInputAddress" placeholder="Address">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputBirthday">Birthday</label>
                                                        <input name="date_of_birth" value="<?php echo htmlentities($row['date_of_birth']); ?>" type="text" class="form-control" id="exampleInputBirthday" placeholder="Birthday">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPhone">Phone</label>
                                                        <input name="phone" value="<?php echo htmlentities($row['phone']); ?>" type="text" class="form-control" id="exampleInputPhone" placeholder="Phone">
                                                    </div>
                                                </div>
                                                <div class="ml-3 col-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Bio</label>
                                                        <textarea name="customer_bio" type="text" class="form-control" id="exampleInputUsername1" placeholder="Enter your bio here..."><?php echo htmlentities($row['customer_bio']); ?></textarea>
                                                    </div>
                                                    <div class="form-group"> 
                                                        <label for="exampleInputGender">Gender</label>
                                                        <div class="ml-3 mt-4">
                                                            <?php if ($row['gender'] == 'Male') { ?>
                                                                <input for="exampleInputGender" name="gender" type="radio" value="Male" checked/>Male
                                                                <input for="exampleInputGender" name="gender" class="ml-3"name="gender" type="radio" value="Female" />Female
                                                            <?php } else { ?>
                                                                <input for="exampleInputGender" name="gender" type="radio" value="Male"/>Male
                                                                <input for="exampleInputGender"  name="gender" class="ml-3"name="gender" type="radio" value="Female" checked/>Female
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="avatar col-3">
                                                    <img src="../assets/img/avatars/<?php echo htmlentities($row['avatar']); ?>" width="200" height="200" alt="Your picture">
                                                    <div class="template-demo">
                                                        <input type="hidden" name="file_old" value="<?php echo htmlentities($row['avatar']); ?>">
                                                        <input type="file" class="btn btn-danger btn-icon-text" name="avatar" style="width: 180px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <button name="update" type="submit" class="btn btn-primary me-2">Submit</button>
                                        <?php } ?>
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
                    </div>
                </div>
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

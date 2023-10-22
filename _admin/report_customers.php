<?php
include('../database/connect.php');
session_start();
if (!isset($_SESSION['account_id'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="../assets/img/others/logo_mini.png" rel="icon">
        <title>Report customer</title>
        <link href="../assets/others/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/others/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/admin/ruang-admin.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>

        <link href="../assets/others/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include('sidebar.php'); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <!-- TopBar -->
                    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                     aria-labelledby="searchDropdown">
                                    <form class="navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                                                   aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>           
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <img class="img-profile rounded-circle" src="../assets/img/avatars/<?php echo $_SESSION['avatar']; ?>" style="max-width: 60px">
                                    <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['account_name']; ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../_users/handling/handling_logout.php">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>




                    <div class="container-fluid" id="container-wrapper">
                        <div id="printableArea">
                            <div class="contentreport" style="text-align:center;">
                                <h2>Customer report</h2>
                                <?php
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $currentTime = date('d/m/Y', time());
                                ?> 
                                <span>Date report: <?php echo $currentTime; ?></span>
                            </div>
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Customer ID</th>
                                            <th>Customer name</th>
                                            <th>Phone</th>
                                            <th>Order</th>   
                                            <th>Cost</th>               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_price = 0;
                                        $total_order = 0;
                                        $query_order = mysqli_query($con, "SELECT accounts.account_id, account_name, phone, COUNT(accounts.account_id) AS COUNT, SUM(purchase_history_total_price) AS PRICE FROM purchases_history, accounts WHERE purchases_history.account_id=accounts.account_id GROUP BY accounts.account_id, account_name, phone;");
                                        while ($row = mysqli_fetch_array($query_order)) {
                                            $GLOBALS['total_price'] += $row['PRICE'];
                                            $GLOBALS['total_order'] += $row['COUNT'];
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($row['account_id']); ?></td>
                                                <td><?php echo htmlentities($row['account_name']); ?></td>
                                                <td><?php echo htmlentities($row['phone']); ?></td>
                                                <td><?php echo htmlentities($row['COUNT']); ?></td>
                                                <td><?php echo htmlentities($row['PRICE']); ?></td>
                                            </tr>
                                        <?php } ?>               
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Customer ID</th>
                                            <th>Customer name</th>
                                            <th>Phone</th>
                                            <th>Order</th>   
                                            <th>Cost</th>               
                                        </tr>
                                        <tr>
                                            <th colspan="3">Total </th>    
                                            <th><?php echo $total_order; ?></th>              
                                            <th>$<?php echo $total_price; ?></th>                  
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div style="text-align: right; margin-bottom:3rem">
                            <Button class="btn btn-sm btn-primary" onclick="printDiv('printableArea')">Export customer</button>
                        </div>

                    </div>






                </div>
            </div>
        </div>
    </div>
    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="../assets/others/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/others/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/others/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/others/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/admin/js/ruang-admin.min.js"></script>

    <script src="../assets/others/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/others/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
                                    function printDiv(divName) {
                                        var printContents = document.getElementById(divName).innerHTML;
                                        var originalContents = document.body.innerHTML;
                                        document.body.innerHTML = printContents;
                                        window.print();
                                        document.body.innerHTML = originalContents;
                                    }
    </script>
</body>

</html>
<?php
include('../database/connect.php');
include('handling/handling_index.php');
if (!isset($_SESSION['account_id'])) {
    header("location:../_users/index.php");
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
        <title>Admin - Dashboard</title>
        <link href="../assets/others/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/others/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">




        <link href="../assets/css/admin/ruang-admin.min.css" rel="stylesheet">
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
                    <!-- Topbar -->

                    <!-- Container Fluid-->
                    <!-- DASHBOARD -->
                    <div class="container-fluid" id="container-wrapper">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>

                        <div class="row mb-3">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Product</div>
                                                <?php
                                                $query_product = mysqli_query($con, "SELECT count_other FROM count_others WHERE count_other_name='products';");
                                                while ($row_product = mysqli_fetch_array($query_product)) {
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($row_product['count_other']); ?></div> 
                                                <?php } ?>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-archive fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Earnings (Annual) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Sales</div>
                                                <?php
                                                $query_sale = mysqli_query($con, "SELECT SUM(count_sale) AS cout FROM count_sales;");
                                                while ($row_sale = mysqli_fetch_array($query_sale)) {
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlentities($row_sale['cout']); ?></div>  
                                                <?php } ?>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- New User Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Customer</div>
                                                <?php
                                                $query_customer = mysqli_query($con, "SELECT count_other FROM count_others WHERE count_other_name='customers';");
                                                while ($row_customer = mysqli_fetch_array($query_customer)) {
                                                    ?>
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo htmlentities($row_customer['count_other']); ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Employee</div>
                                                <?php
                                                $query_employee = mysqli_query($con, "SELECT count_other FROM count_others WHERE count_other_name='employees';");
                                                while ($row_employee = mysqli_fetch_array($query_employee)) {
                                                    ?>
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo htmlentities($row_employee['count_other']); ?></div>
                                                <?php } ?>                  
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-alt fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title">Charts</h5>
                                        <?php
                                        $sale = "";
                                        $revenue = "";
                                        $datetime = "";
                                        $query_history = mysqli_query($con, "SELECT purchase_history_all_quantity, purchase_history_total_price, created_date_purchase_history FROM purchases_history;");
                                        while ($row_history = mysqli_fetch_array($query_history)) {
                                            $number_product = 0;
                                            //revenue in day
                                            $GLOBALS['revenue'] = $GLOBALS['revenue'] . $row_history['purchase_history_total_price'] . ",";
                                            //date to show charts
                                            $GLOBALS['datetime'] = $GLOBALS['datetime'] . "'" . $row_history['created_date_purchase_history'] . "',";

                                            $purchase_history_all_quantity = explode(',', $row_history['purchase_history_all_quantity']);
                                            for ($i = 0; $i < count($purchase_history_all_quantity); $i++) {
                                                $number_product += (int)$purchase_history_all_quantity[$i];
                                            }
                                            //sale in day
                                            $GLOBALS['sale'] = $GLOBALS['sale'] . "$number_product,";
                                        }
                                        $sale = substr($sale, 0, strlen($sale) - 1);
                                        $revenue = substr($revenue, 0, strlen($revenue) - 1);
                                        $datetime = substr($datetime, 0, strlen($datetime) - 1);
                                        ?>
                                        <div id="reportsChart"></div>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new ApexCharts(document.querySelector("#reportsChart"), {
                                                    series: [{
                                                            name: 'Sales',
                                                            data: [<?php echo $sale; ?>]
                                                        }, {
                                                            name: 'Revenue',
                                                            data: [<?php echo $revenue; ?>]
                                                        }],
                                                    chart: {
                                                        height: 350,
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        }
                                                    },
                                                    markers: {
                                                        size: 4
                                                    },
                                                    colors: ['#4154f1', '#2eca6a'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        categories: [<?php echo $datetime; ?>]
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        }
                                                    }
                                                }).render();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>


                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card mb-4">             
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Month <i class="fas fa-chevron-down"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                 aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Select Periode</div>
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Week</a>
                                                <a class="dropdown-item active" href="#">Month</a>
                                                <a class="dropdown-item" href="#">This Year</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $query_sales = mysqli_query($con, "SELECT product_name, product_quantity, count_sale FROM count_sales, products WHERE products.product_id=count_sales.product_id ORDER BY count_sale DESC LIMIT 5;");
                                        while ($row_sale = mysqli_fetch_array($query_sales)) {
                                            ?>
                                            <div class="mb-3">
                                                <div class="small text-gray-500"><?php echo htmlentities(substr($row_sale['product_name'], 0, 30)); ?>...
                                                    <div class="small float-right"><b><?php echo htmlentities($row_sale['count_sale']); ?> of <?php echo htmlentities($row_sale['product_quantity']); ?> Items</b></div>
                                                </div>
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo htmlentities(($row_sale['count_sale'] / $row_sale['product_quantity']) * 100); ?>%" aria-valuenow="<?php echo htmlentities(($row_sale['count_sale'] / $row_sale['product_quantity']) * 100); ?>"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a class="m-0 small text-primary card-link" href="#">View More <i
                                                class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Example -->
                            <div class="col-xl-8 col-lg-7 mb-4">
                                <div class="card">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Invoice</h6>
                                        <!-- <a class="m-0 float-right btn btn-danger btn-sm" href="#">
                                          View More 
                                          <i class="fas fa-chevron-right"></i></a> -->
                                    </div>
                                    <div class="table-responsive">


                                        <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                            <thead class="thead-light">
                                                <tr  style="text-align: center;">
                                                    <th>Order ID</th>
                                                    <th>Customer name</th>                 
                                                    <th>Address</th>
                                                    <th>Status</th>
                                                    <th>View Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody  style="text-align: center;">
                                                <?php
                                                $infor_all_order = "order_id, order_name, order_address, order_status_id";
                                                $query_all_order = mysqli_query($con, "SELECT " . $infor_all_order . " FROM orders LIMIT 5;");
                                                while ($row = mysqli_fetch_array($query_all_order)) {
                                                    ?>
                                                    <tr>
                                                        <td><a href="#"><?php echo htmlentities($row['order_id']); ?></a></td>
                                                        <td><?php echo htmlentities($row['order_name']); ?></td>
                                                        <td><?php echo htmlentities(substr($row['order_address'], 0, 20)); ?>...</td>                      
                                                        <?php if ($row['order_status_id'] == 1) { ?>
                                                            <td><span class="badge badge-warning">Waiting</span></td>
                                                        <?php } elseif ($row['order_status_id'] == 2) { ?>
                                                            <td><span class="badge badge-info">Delivery</span></td>
                                                        <?php } elseif ($row['order_status_id'] == 3) { ?>
                                                            <td><span class="badge badge-success">Completed</span></td>
                                                        <?php } elseif ($row['order_status_id'] == 4) { ?>
                                                            <td><span class="badge badge-secondary">Pending</span></td>
                                                        <?php } ?>
                                                        <td><a href="update_orders.php?order_id=<?php echo htmlentities($row['order_id']); ?>" class="btn btn-sm btn-primary">Detail</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                            <!-- Message From Customer-->
                            <!-- <div class="col-xl-4 col-lg-5 ">
                              <div class="card">
                                <div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
                                  <h6 class="m-0 font-weight-bold text-light">Option for admin</h6>
                                </div>
                                <div class="grid-container mt-4 ml-5 mb-4">
                                  <button type="button" class="btn btn-warning mb-1">View Customer</button>
                                  <button type="button" class="btn btn-warning mb-1">View Employee</button>
                                  <button type="button" class="btn btn-warning mb-1">View Product</button>
                                  <button type="button" class="btn btn-warning mb-1">View Category</button>                 
                                </div>
                              </div>
                            </div> -->
                        </div>
                        <!--Row-->


                        <!-- Modal Logout -->
                        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to logout?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                        <a href="login.html" class="btn btn-primary">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!---Container Fluid-->
                </div>
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">From <a href="../../_Users/home.html" target="_blank">MEOW SHOP</a> with love</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2022</span>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- Footer -->
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <script src="../assets/others/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="../assets/others/vendor/jquery/jquery.min.js"></script>
        <script src="../assets/others/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/others/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../assets/js/admin/js/ruang-admin.min.js"></script>
        <script src="../assets/others/vendor/chart.js/Chart.min.js"></script>
        <script src="../assets/js/admin/chart-area-demo.js"></script>  
    </body>
</html>
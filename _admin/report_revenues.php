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
        <title>Revenue</title>
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



                    <!-- Container Fluid-->
                    <div class="row container-fluid" style="width:50%; margin-left:60%;">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="row">
                                <div action="" class="form-group col-4">
                                    <label for="stardate">Start date</label>
                                    <div>
                                        <input type="date" id="stardate" name="startdate" class="form-control" value="03/12/1999">    
                                    </div>                
                                </div>
                                <div action="" class="form-group col-4">
                                    <label for="enddate">End date</label>
                                    <div>
                                        <input type="date" id="enddate" name="enddate" class="form-control" value="03/12/1999">    
                                    </div>                
                                </div> 
                                <div action="" class="form-group col-4" style="padding-top: 35px">
                                    <button type="submit" name="report" class="btn btn-primary">Submit</button>               
                                </div>
                            </div>
                        </form>
                    </div>




                    <?php
                    if (!isset($_POST['report'])) {
                        $start;
                        $end;
                        $query_date = mysqli_query($con, "SELECT MIN(created_date_purchase_history) AS start, MAX(created_date_purchase_history) AS end FROM purchases_history;");
                        while ($row = mysqli_fetch_array($query_date)) {
                            $GLOBALS['start'] = $row['start'];
                            $GLOBALS['end'] = $row['end'];
                        }
                        ?>
                        <div>
                            <div style="text-align: left;margin-left: 3rem;">
                                <a class="btn btn-sm btn-primary" href="report_pdf.php?start=<?php echo $start; ?>&end=<?php echo $end; ?>">Export revenue</a>
                            </div>

                            <div class="container-fluid" id="invoice">
                                <div class="contentreport" style="text-align:center;">
                                    <h2>Revenue report from <?php echo date('d/m/Y', strtotime($start)); ?> to <?php echo date('d/m/Y', strtotime($end)); ?> </h2>
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
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Orders</th>                  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $count = 0;
                                            $query_order = mysqli_query($con, "SELECT * FROM purchases_history WHERE created_date_purchase_history BETWEEN '$start' AND '$end';");
                                            while ($row = mysqli_fetch_array($query_order)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row['purchase_history_name']); ?></td>
                                                    <td><?php echo htmlentities($row['purchase_history_address']); ?></td>
                                                    <td><?php echo htmlentities($row['purchases_history_phone']); ?></td>
                                                    <td>
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Product name</th>
                                                                    <th>Price</th>
                                                                    <th>Quantity</th>
                                                                    <th>Cost</th>                  
                                                                </tr>
                                                                <?php
                                                                //split order
                                                                $purchase_history_product_all_id = explode(',', $row['purchase_history_product_all_id']);
                                                                $purchase_history_all_quantity = explode(',', $row['purchase_history_all_quantity']);
                                                                for ($i = 0; $i < count($purchase_history_product_all_id); $i++) {
                                                                    $infor_product = "products.product_id, product_name, product_price, product_image_1, discount";
                                                                    $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, count_sales, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND count_sales.product_id=products.product_id AND products.product_id=$purchase_history_product_all_id[$i];");
                                                                    while ($row_product = mysqli_fetch_array($query_products)) {
                                                                        $GLOBALS['total'] += ($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $purchase_history_all_quantity[$i];
                                                                        $GLOBALS['count']++;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo htmlentities($row_product['product_name']); ?></td>
                                                                            <td>$<?php echo htmlentities($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))); ?></td>
                                                                            <td><?php echo $purchase_history_all_quantity[$i]; ?></td>
                                                                            <td>$<?php echo htmlentities(($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $purchase_history_all_quantity[$i]); ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                <?php } ?> 
                                                            </tbody> 
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Order</th>
                                                <th></th>
                                                <th></th>
                                                <th>Total Cost</th>                  
                                            </tr>
                                            <tr>
                                                <th><?php echo $count; ?></th>
                                                <th></th>
                                                <th></th>
                                                <th>$<?php echo $total; ?></th>                  
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div id="main" class="main">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title">Charts</h5>
                                                <?php
                                                $revenue = "";
                                                $datetime = "";
                                                $query_history = mysqli_query($con, "SELECT purchase_history_total_price, created_date_purchase_history FROM purchases_history WHERE created_date_purchase_history BETWEEN '$start' AND '$end';;");
                                                while ($row_history = mysqli_fetch_array($query_history)) {
                                                    //revenue in day
                                                    $GLOBALS['revenue'] = $GLOBALS['revenue'] . $row_history['purchase_history_total_price'] . ",";
                                                    //date to show charts
                                                    $GLOBALS['datetime'] = $GLOBALS['datetime'] . "'" . $row_history['created_date_purchase_history'] . "',";
                                                }
                                                $revenue = substr($revenue, 0, strlen($revenue) - 1);
                                                $datetime = substr($datetime, 0, strlen($datetime) - 1);
                                                ?>
                                                <div id="reportsChart"></div>
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", () => {
                                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                                            series: [{
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
                                                            colors: ['#2eca6a'],
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

                                </div>


                            </div>

                        </div>
                    <?php } else { 
                        $start = $_POST['startdate'];
                        $end = $_POST['enddate'];
                        ?>

                        <div>
                            <div style="text-align: left;margin-left: 3rem;">
                                <a class="btn btn-sm btn-primary" href="report_pdf.php?start=<?php echo $start; ?>&end=<?php echo $end; ?>">Export revenue</a>
                            </div>

                            <div class="container-fluid" id="invoice">
                                <div class="contentreport" style="text-align:center;">
                                    <h2>Revenue report from <?php echo date('d/m/Y', strtotime($start)); ?> to <?php echo date('d/m/Y', strtotime($end)); ?> </h2>
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
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Orders</th>                  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $count = 0;
                                            $start = date('Y-m-d', strtotime($start));
                                            $end = date('Y-m-d', strtotime($end));
                                            $query_order = mysqli_query($con, "SELECT * FROM purchases_history WHERE created_date_purchase_history BETWEEN '$start' AND '$end';");
                                            while ($row = mysqli_fetch_array($query_order)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row['purchase_history_name']); ?></td>
                                                    <td><?php echo htmlentities($row['purchase_history_address']); ?></td>
                                                    <td><?php echo htmlentities($row['purchases_history_phone']); ?></td>
                                                    <td>
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Product name</th>
                                                                    <th>Price</th>
                                                                    <th>Quantity</th>
                                                                    <th>Cost</th>                  
                                                                </tr>
                                                                <?php
                                                                //split order
                                                                $purchase_history_product_all_id = explode(',', $row['purchase_history_product_all_id']);
                                                                $purchase_history_all_quantity = explode(',', $row['purchase_history_all_quantity']);
                                                                for ($i = 0; $i < count($purchase_history_product_all_id); $i++) {
                                                                    $infor_product = "products.product_id, product_name, product_price, product_image_1, discount";
                                                                    $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, count_sales, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND count_sales.product_id=products.product_id AND products.product_id=$purchase_history_product_all_id[$i];");
                                                                    while ($row_product = mysqli_fetch_array($query_products)) {
                                                                        $GLOBALS['total'] += ($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $purchase_history_all_quantity[$i];
                                                                        $GLOBALS['count']++;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo htmlentities($row_product['product_name']); ?></td>
                                                                            <td>$<?php echo htmlentities($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))); ?></td>
                                                                            <td><?php echo $purchase_history_all_quantity[$i]; ?></td>
                                                                            <td>$<?php echo htmlentities(($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $purchase_history_all_quantity[$i]); ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                <?php } ?> 
                                                            </tbody> 
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Order</th>
                                                <th></th>
                                                <th></th>
                                                <th>Total Cost</th>                  
                                            </tr>
                                            <tr>
                                                <th><?php echo $count; ?></th>
                                                <th></th>
                                                <th></th>
                                                <th>$<?php echo $total; ?></th>                  
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div id="main" class="main">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title">Charts</h5>
                                                <?php
                                                $revenue = "";
                                                $datetime = "";
                                                $query_history = mysqli_query($con, "SELECT purchase_history_total_price, created_date_purchase_history FROM purchases_history WHERE created_date_purchase_history BETWEEN '$start' AND '$end';");
                                                while ($row_history = mysqli_fetch_array($query_history)) {
                                                    //revenue in day
                                                    $GLOBALS['revenue'] = $GLOBALS['revenue'] . $row_history['purchase_history_total_price'] . ",";
                                                    //date to show charts
                                                    $GLOBALS['datetime'] = $GLOBALS['datetime'] . "'" . $row_history['created_date_purchase_history'] . "',";
                                                }
                                                $revenue = substr($revenue, 0, strlen($revenue) - 1);
                                                $datetime = substr($datetime, 0, strlen($datetime) - 1);
                                                ?>
                                                <div id="reportsChart"></div>
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", () => {
                                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                                            series: [{
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
                                                            colors: ['#2eca6a'],
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

                                </div>


                            </div>

                        </div>
                    <?php } ?>


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
                                                    window.onload = function () {
                                                        document.getElementById("download")
                                                                .addEventListener("click", () => {
                                                                    const invoice = this.document.getElementById("invoice");
                                                                    console.log(invoice);
                                                                    console.log(window);
                                                                    var opt = {
                                                                        margin: 1,
                                                                        filename: 'myfile.pdf',
                                                                        image: {type: 'jpeg', quality: 0.98},
                                                                        html2canvas: {scale: 2},
                                                                        jsPDF: {unit: 'in', format: 'A4', orientation: 'portrait'}
                                                                    };
                                                                    html2pdf().from(invoice).set(opt).save();
                                                                });
                                                    };
    </script>
</body>

</html>
<?php
include('../database/connect.php');
include('handling/handling_update_orders.php');
if (!isset($_SESSION['account_id']) && !isset($_SESSION['update_by_id'])) {
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
        <title>Order</title>
        <link href="../assets/others/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/others/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/admin/ruang-admin.min.css" rel="stylesheet">

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
                    <div class="container-fluid" id="container-wrapper">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">View Order</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item">Order</li>
                                <li class="breadcrumb-item">View Order</li>
                                <li class="breadcrumb-item active" aria-current="page">Update Order</li>
                            </ol>
                        </div>         

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Order</h6>
                                </div>
                                <form class="forms-sample ml-5 mb-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <?php
                                    $total = 0;
                                    $query_order = mysqli_query($con, "SELECT * FROM orders WHERE order_id=" . $_SESSION['update_by_id'] . ";");
                                    while ($row = mysqli_fetch_array($query_order)) {
                                        ?>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>ID Order: </label>
                                                    <a><?php echo htmlentities($row['order_id']); ?></a>
                                                </div>
                                                <div class="form-group">
                                                    <label>Customer name: </label>
                                                    <a><?php echo htmlentities($row['order_name']); ?></a>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Address: </label>
                                                    <a><?php echo htmlentities($row['order_address']); ?></a>
                                                </div>    
                                                <div class="form-group">
                                                    <label>Phone: </label>
                                                    <a><?php echo htmlentities($row['order_phone']); ?></a>
                                                </div>     
                                            </div>    
                                            <div class="ml-3 col-4">
                                                <div class="form-group">
                                                    <label>Order Date: </label>
                                                    <a><?php echo htmlentities($row['date_invoice_order']); ?></a>
                                                </div>                  
                                                <div class="form-group">
                                                    <label>Status: </label>
                                                    <?php
                                                    if ($row['order_status_id'] == 4) {
                                                        $query_order_status = mysqli_query($con, "SELECT order_status_name FROM order_status WHERE order_status_id=" . $row['order_status_id'] . ";");
                                                        while ($row_pending = mysqli_fetch_array($query_order_status)) {
                                                            ?>
                                                            <a><?php echo htmlentities($row_pending['order_status_name']); ?></a>
                                                        <?php } ?>
                                                        <?php
                                                    } elseif ($row['order_status_id'] == 3) {
                                                        $query_order_status = mysqli_query($con, "SELECT order_status_name FROM order_status WHERE order_status_id=" . $row['order_status_id'] . ";");
                                                        while ($row_pending = mysqli_fetch_array($query_order_status)) {
                                                            ?>
                                                            <a><?php echo htmlentities($row_pending['order_status_name']); ?></a>
                                                        <?php } ?>    
                                                    <?php } else { ?>              
                                                        <select name="order_status_id" class="form-control">
                                                            <?php
                                                            $query_all_order_status = mysqli_query($con, "SELECT order_status_id, order_status_name FROM order_status;");
                                                            while ($row_order_status = mysqli_fetch_array($query_all_order_status)) {
                                                                ?>
                                                                <?php if ($row_order_status['order_status_id'] == $row['order_status_id']) { ?>
                                                                    <option value="<?php echo htmlentities($row_order_status['order_status_id']); ?>" selected><?php echo htmlentities($row_order_status['order_status_name']); ?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo htmlentities($row_order_status['order_status_id']); ?>"><?php echo htmlentities($row_order_status['order_status_name']); ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } ?>
                                                </div> 
                                                <div class="form-group">
                                                    <label>Note: </label>
                                                    <a><?php echo htmlentities($row['order_notes']); ?></a>
                                                </div> 
                                            </div>  
                                            <div class="col-11">
                                                <table class="table select-table">
                                                    <thead>
                                                        <tr>                      
                                                            <th>#</th>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                            <th>Cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $count = 1;
                                                        //split order
                                                        $order_product_all_id = explode(',', $row['order_product_all_id']);
                                                        $order_all_quantity = explode(',', $row['order_all_quantity']);
                                                        for ($i = 0; $i < count($order_product_all_id); $i++) {
                                                            $infor_product = "products.product_id, product_name, product_price, product_image_1, discount";
                                                            $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, count_sales, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND count_sales.product_id=products.product_id AND products.product_id=$order_product_all_id[$i];");
                                                            while ($row_product = mysqli_fetch_array($query_products)) {
                                                                $GLOBALS['total'] += ($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $order_all_quantity[$i];
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <h6><?php
                                                                            echo $GLOBALS['count'];
                                                                            $GLOBALS['count']++;
                                                                            ?></h6>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <img src="../assets/img/image_products/<?php echo htmlentities($row_product['product_image_1']); ?>" width="50" height="50" >
                                                                            <div class="pt-3">
                                                                                <h6><?php echo htmlentities(substr($row_product['product_name'], 0, 30)); ?>...</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h6>$<?php echo htmlentities($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))); ?></h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6><?php echo $order_all_quantity[$i]; ?></h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6>$<?php echo htmlentities(($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $order_all_quantity[$i]); ?></h6>
                                                                    </td>
                                                                </tr>  
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <hr style="color:Gray">
                                                <div class="row container-fluid">                  
                                                    <div class="col" style="text-align: right; font-size:20px;margin-right: 50px;">
                                                        Total:<span>$<?php echo $total ?></span>
                                                    </div>
                                                </div>
                                                <input name="purchase_history_total_price" type="hidden" value="<?php echo $total; ?>">
                                            </div>
                                        </div>                                      
                                    <?php } ?>
                                    <button name="update" type="submit" class="btn btn-primary me-2">Submit</button>
                                    <a href="view_orders.php" class="btn btn-light">Cancel</a>
                                </form>
                            </div>
                        </div>

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
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="../assets/others/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/others/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/others/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/admin/js/ruang-admin.min.js"></script>

    <script src="../assets/others/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/others/vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>
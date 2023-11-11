<?php
include('../database/connect.php');
include('handling/handling_account_order.php');
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

        <link rel="stylesheet" href="../assets/others/vendor/select2/select2.min.css">
        <link rel="stylesheet" href="../assets/others/vendor/select2-bootstrap-theme/select2-bootstrap.min.css">

        <link rel="stylesheet" href="../assets/css/users/account_page.css">

        <link href="../assets/img/others/logo_mini.png" rel="icon">
    </head>

    <body>
        <div class="container-scroller">
            <!-- partial:../../partials/_navbar.html -->
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
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <?php
                include('nav_account.php');
                ?>
                <!-- waiting -->
                <div class="row flex-grow col-6">
                    <div class="content-wrapper">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="card-title card-title-dash">Waiting</h4>                    
                                        </div>                  
                                    </div>
                                    <?php
                                    $query_order = mysqli_query($con, "SELECT * FROM orders WHERE account_id=" . $_SESSION['account_id'] . " AND order_status_id=1;");
                                    while ($row = mysqli_fetch_array($query_order)) {
                                        $total = 0;
                                        ?>
                                        <hr style="color:brown">
                                        <div class="infor_product mt-3 row">
                                            <div class="col-4">
                                                <div class="id_product">
                                                    Order ID: 
                                                    <span href="" class="id_order_input"><?php echo htmlentities($row['order_id']); ?></span>
                                                </div>
                                                <div class="Address">
                                                    Address: 
                                                    <span href="" class="address_order_input"><?php echo htmlentities($row['order_address']); ?></span>
                                                </div>
                                                <div class="Phone">
                                                    Phone: 
                                                    <span href="" class="phone_order_input"><?php echo htmlentities($row['order_phone']); ?></span>
                                                </div>
                                            </div>     
                                            <div class="col">
                                                <div class="Date">
                                                    Date: 
                                                    <span href="" class="Date_order_input"><?php echo htmlentities(substr($row['date_invoice_order'], 0, strlen($row['date_invoice_order']) - 9)); ?></span>
                                                </div>
                                                <div>
                                                    Status:
                                                    <span href="" class="Status_order">
                                                        <div class="badge badge-opacity-warning">Waiting</div>
                                                    </span>
                                                </div>
                                            </div>             
                                        </div>                
                                        <div class="table-responsive  mt-1">
                                            <table class="table select-table">
                                                <thead>
                                                    <tr>                      
                                                        <th>#</th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Amount</th>
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
                                                        $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND products.product_id=$order_product_all_id[$i];");
                                                        while ($row_product = mysqli_fetch_array($query_products)) {
                                                            $GLOBALS['total'] += ($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $order_all_quantity[$i];
                                                            ?>
                                                            <tr>
                                                                <td class="pt-4 pt-3">
                                                                    <h6><?php
                                                                        echo $GLOBALS['count'];
                                                                        $GLOBALS['count']++;
                                                                        ?></h6>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex ">
                                                                        <img src="../assets/img/image_products/<?php echo htmlentities($row_product['product_image_1']); ?>" alt="">
                                                                        <div class="pt-3">
                                                                            <h6><?php echo htmlentities($row_product['product_name']); ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6>$<?php echo htmlentities($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))); ?></h6>
                                                                </td>
                                                                <td  style="padding-left: 20px;">
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
                                                <div class="col">
                                                    <a href="account_order.php?delete_order_id=<?php echo htmlentities($row['order_id']); ?>" class="btn btn-danger btn-icon-text">
                                                        Pending
                                                    </a>
                                                </div>                    
                                                <div class="col" style="text-align: right; font-size:20px;margin-right: 50px;">
                                                    Total:<span>$<?php echo $total ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="content-wrapper">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="card-title card-title-dash">In process</h4>                    
                                        </div>                  
                                    </div>
                                    <?php
                                    $query_order = mysqli_query($con, "SELECT * FROM orders WHERE account_id=" . $_SESSION['account_id'] . " AND order_status_id=2;");
                                    while ($row = mysqli_fetch_array($query_order)) {
                                        $total = 0;
                                        ?>
                                        <hr style="color:brown">
                                        <div class="infor_product mt-3 row">
                                            <div class="col-4">
                                                <div class="id_product">
                                                    Order ID: 
                                                    <span href="" class="id_order_input"><?php echo htmlentities($row['order_id']); ?></span>
                                                </div>
                                                <div class="Address">
                                                    Address: 
                                                    <span href="" class="address_order_input"><?php echo htmlentities($row['order_address']); ?></span>
                                                </div>
                                                <div class="Phone">
                                                    Phone: 
                                                    <span href="" class="phone_order_input"><?php echo htmlentities($row['order_phone']); ?></span>
                                                </div>
                                            </div>     
                                            <div class="col">
                                                <div class="Date">
                                                    Date: 
                                                    <span href="" class="Date_order_input"><?php echo htmlentities(substr($row['date_invoice_order'], 0, strlen($row['date_invoice_order']) - 9)); ?></span>
                                                </div>
                                                <div>
                                                    Status:
                                                    <span href="" class="Status_order">
                                                        <div class="badge badge-opacity-success">In process</div>
                                                    </span>
                                                </div>
                                            </div>             
                                        </div>                
                                        <div class="table-responsive  mt-1">
                                            <table class="table select-table">
                                                <thead>
                                                    <tr>                      
                                                        <th>#</th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Amount</th>
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
                                                        while ($row = mysqli_fetch_array($query_products)) {
                                                            $GLOBALS['total'] += ($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))) * $order_all_quantity[$i];
                                                            ?>
                                                            <tr>
                                                                <td class="pt-4 pt-3">
                                                                    <h6><?php
                                                                        echo $GLOBALS['count'];
                                                                        $GLOBALS['count']++;
                                                                        ?></h6>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex ">
                                                                        <img src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" alt="">
                                                                        <div class="pt-3">
                                                                            <h6><?php echo htmlentities($row['product_name']); ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6>$<?php echo htmlentities($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))); ?></h6>
                                                                </td>
                                                                <td  style="padding-left: 20px;">
                                                                    <h6><?php echo $order_all_quantity[$i]; ?></h6>
                                                                </td>
                                                                <td>
                                                                    <h6>$<?php echo htmlentities(($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))) * $order_all_quantity[$i]); ?></h6>
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
                                        </div>
                                    <?php } ?>
                                </div>
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

        <script src="../assets/others/vendor/typeahead.js/typeahead.bundle.min.js"></script>
        <script src="../assets/others/vendor/select2/select2.min.js"></script>
        <script src="../assets/others/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

        <script src="../assets/js/off-canvas.js"></script>
        <script src="../assets/js/hoverable-collapse.js"></script>
        <script src="../assets/js/template.js"></script>
        <script src="../assets/js/settings.js"></script>
        <script src="../assets/js/todolist.js"></script>

        <script src="../assets/js/file-upload.js"></script>
        <script src="../assets/js/typeahead.js"></script>
        <script src="../assets/js/select2.js"></script>
    </body>

</html>

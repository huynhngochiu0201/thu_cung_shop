<?php
include('../database/connect.php');
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
                font: 12pt "Tohoma";
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            .page {
                width: 21cm;
                overflow:hidden;
                min-height:297mm;
                padding: 2.5cm;
                margin-left:auto;
                margin-right:auto;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }
            .subpage {
                padding: 1cm;
                border: 5px red solid;
                height: 237mm;
                outline: 2cm #FFEAEA solid;
            }
            @page {
                size: A4;
                margin: 0;
            }
            button {
                width:100px;
                height: 24px;
            }
            .header {
                overflow:hidden;
            }
            .logo {
                background-color:#FFFFFF;
                text-align:left;
                float:left;
            }
            .company {
                padding-top:24px;
                text-transform:uppercase;
                background-color:#FFFFFF;
                text-align:right;
                float:right;
                font-size:16px;
            }
            .title {
                text-align:center;
                position:relative;
                color:#0000FF;
                font-size: 24px;
                top:1px;
            }
            .footer-left {
                text-align:center;
                text-transform:uppercase;
                padding-top:24px;
                position:relative;
                height: 150px;
                width:50%;
                color:#000;
                float:left;
                font-size: 12px;
                bottom:1px;
            }
            .footer-right {
                text-align:center;
                text-transform:uppercase;
                padding-top:24px;
                position:relative;
                height: 150px;
                width:50%;
                color:#000;
                font-size: 12px;
                float:right;
                bottom:1px;
            }
            .TableData {
                background:#ffffff;
                font: 11px;
                width:100%;
                border-collapse:collapse;
                font-family:Verdana, Arial, Helvetica, sans-serif;
                font-size:12px;
                border:thin solid #d3d3d3;
            }
            .TableData TH {
                background: rgba(0,0,255,0.1);
                text-align: center;
                font-weight: bold;
                color: #000;
                border: solid 1px #ccc;
                height: 24px;
            }
            .TableData TR {
                height: 24px;
                border:thin solid #d3d3d3;
            }
            .TableData TR TD {
                padding-right: 2px;
                padding-left: 2px;
                border:thin solid #d3d3d3;
            }
            .TableData TR:hover {
                background: rgba(0,0,0,0.05);
            }
            .TableData .cotSTT {
                text-align:center;
                width: 10%;
            }
            .TableData .cotTenSanPham {
                text-align:left;
                width: 40%;
            }
            .TableData .cotHangSanXuat {
                text-align:left;
                width: 20%;
            }
            .TableData .cotGia {
                text-align:right;
                width: 120px;
            }
            .TableData .cotSoLuong {
                text-align: center;
                width: 50px;
            }
            .TableData .cotSo {
                text-align: right;
                width: 120px;
            }
            .TableData .tong {
                text-align: right;
                font-weight:bold;
                text-transform:uppercase;
                padding-right: 4px;
            }
            .TableData .cotSoLuong input {
                text-align: center;
            }
            @media print {
                @page {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                }
            }
        </style>
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
    <body onload="window.print();">
        <?php
        $start = $_GET['start'];
        $end = $_GET['end'];
        ?>
        <div id="page" class="page">
            <div class="header">
                <div class="logo"><img src="../assets/img/others/logo_meow.png" width="100" height="50"/></div>
            </div>
            <br/>
            <div class="title">
                REPORT REVENUE
                <br/>
                -------oOo-------
            </div>
            <br/>
            <br/>
            <div class="contentreport" style="text-align:center;">
                <h2>Revenue report from <?php echo date('d/m/Y', strtotime($start)); ?> to <?php echo date('d/m/Y', strtotime($end)); ?> </h2>
                <?php
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentTime = date('d/m/Y', time());
                ?> 
                <span>Date report: <?php echo $currentTime; ?></span>
            </div>
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
        </div>
    </body>
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
</html>
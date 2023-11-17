<?php

session_start();
if (isset($_POST['orders'])) {
    $order_product_all_id = substr($_POST['order_product_all_id'], 0, strlen($_POST['order_product_all_id']) - 1);
    $order_all_quantity = substr($_POST['order_all_quantity'], 0, strlen($_POST['order_all_quantity']) - 1);
    $order_name = $_POST['order_name'];
    $order_address = $_POST['order_address'];
    $order_phone = $_POST['order_phone'];
    $order_notes = $_POST['order_notes'];
    $order_status_id = 1;

    $insert_order = mysqli_query($con, "INSERT INTO orders (account_id, order_product_all_id, order_all_quantity, order_name, order_address, order_phone, order_notes, order_status_id) "
            . "VALUES ('" . $_SESSION['account_id'] . "', '$order_product_all_id', '$order_all_quantity', '$order_name', '$order_address', '$order_phone', '$order_notes', '$order_status_id');");
    if ($insert_order > 0) {
        //reduce number of product
        $product = explode(',', $order_product_all_id);
        $delete_quatity = explode(',', $order_all_quantity);
        for ($i = 0; $i < count($product); $i++) {
            mysqli_query($con, "UPDATE products SET product_quantity=product_quantity-" . (int) $delete_quatity[$i] . " WHERE product_id=" . (int) $product[$i] . ";");
        }

        //delete all carts
        if ($_SESSION['delete_cart'] == 1) {
            $delete_carts = mysqli_query($con, "DELETE FROM carts WHERE account_id=" . $_SESSION['account_id'] . ";");
        }
        header("location:account_order.php");
    } else {
        echo "<script>alert('Order product failed!');</script>";
    }
}
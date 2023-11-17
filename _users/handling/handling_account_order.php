<?php

session_start();
if (isset($_GET['delete_order_id'])) {
    $order_id = $_GET['delete_order_id'];
    $delete_carts = mysqli_query($con, "DELETE FROM orders WHERE order_id=$order_id;");
    if ($delete_carts > 0) {
        echo "<script>alert('Pending successful!');</script>";
    } else {
        echo "<script>alert('Pending failed!');</script>";
    }
}
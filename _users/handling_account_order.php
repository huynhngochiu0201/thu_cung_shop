<?php

session_start();

function deleteOrder($con, $orderId)
{
    $deleteOrderQuery = "DELETE FROM orders WHERE order_id=$orderId;";
    $deleteResult = mysqli_query($con, $deleteOrderQuery);

    if ($deleteResult > 0) {
        return true;  // Xóa thành công
    } else {
        return false;  // Xóa không thành công
    }
}

if (isset($_GET['delete_order_id'])) {
    $order_id = $_GET['delete_order_id'];
    $delete_carts = mysqli_query($con, "DELETE FROM orders WHERE order_id=$order_id;");
    if ($delete_carts > 0) {
        echo "<script>alert('Pending successful!');</script>";
    } else {
        echo "<script>alert('Pending failed!');</script>";
    }
}
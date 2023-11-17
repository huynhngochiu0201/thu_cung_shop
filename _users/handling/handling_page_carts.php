<?php

session_start();
if (!isset($_SESSION['account_id'])) {
    header("location:login.php");
}
if ((isset($_GET['product_id']) && isset($_GET['cart_quantity'])) || isset($_GET['add'])) {
    $product_id = $_GET['product_id'];
    $cart_quantity = $_GET['cart_quantity'];
    if (isset($_GET['checkout'])) {
        //redirect the check out page to payment
        header("location:checkout.php?product_id=$product_id&cart_quantity=$cart_quantity");
    } else {
        $check_exist = mysqli_query($con, "SELECT * FROM carts WHERE product_id='$product_id' AND account_id=" . $_SESSION['account_id'] . ";");
        $num = mysqli_fetch_array($check_exist);
        if ($num == 0) {
            //insert to cart
            mysqli_query($con, "INSERT INTO carts (account_id, product_id, cart_quantity) VALUES ('" . $_SESSION['account_id'] . "', '$product_id', '$cart_quantity');");
        }
    }
}
if (isset($_GET['delete'])) {
    $product_id = $_GET['product_id'];
    $delete_carts = mysqli_query($con, "DELETE FROM carts WHERE account_id=" . $_SESSION['account_id'] . " AND product_id=$product_id;");
    if ($delete_carts) {
        echo "<script>alert('Delete product successfully!');</script>";
    } else {
        echo "<script>alert('Delete product failed!');</script>";
    }
}
if (isset($_POST['update_carts'])) {
    $update_quantity;
    $query_carts = mysqli_query($con, "SELECT product_id FROM carts WHERE account_id=" . $_SESSION['account_id'] . ";");
    while ($row = mysqli_fetch_array($query_carts)) {
        $quantity = 'cart_quantity_' . $row['product_id'];
        $cart_quantity = $_POST[$quantity];
        $product = 'product_' . $row['product_id'];
        $product_id = $_POST[$product];
        $GLOBALS['update_quantity'] = mysqli_query($con, "UPDATE carts SET cart_quantity=$cart_quantity WHERE account_id=" . $_SESSION['account_id'] . " AND product_id=$product_id;");
        if (!$GLOBALS['update_quantity']) {
            break;
        }
    }
    if ($update_quantity) {
        echo "<script>alert('Update cart successful!');</script>";
    } else {
        echo "<script>alert('Update cart failed!');</script>";
    }
}
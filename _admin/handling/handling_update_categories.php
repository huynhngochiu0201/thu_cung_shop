<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['product_type_id'])) {
    $_SESSION['update_by_id'] = $_GET['product_type_id'];
}

if (isset($_POST['update'])) {
    $product_type_name = test_input($_POST['product_type_name']);
    $coupon_id = test_input($_POST['coupon_id']);

    $update_category = mysqli_query($con, "UPDATE product_types SET product_type_name='$product_type_name', coupon_id='$coupon_id' WHERE product_type_id=" . $_SESSION['update_by_id'] . ";");
    if ($update_category) {
        echo "<script>alert('Update category successful!');</script>";
    } else {
        echo "<script>alert('Update category failed!');</script>";
    }
}
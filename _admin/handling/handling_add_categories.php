<?php

session_start();

if (isset($_POST['add_categories'])) {
    $product_type_name = $_POST['product_type_name'];
    $coupon_id = $_POST['coupon_id'];

    $insert_category = mysqli_query($con, "INSERT INTO product_types (product_type_name, coupon_id) VALUES ('$product_type_name', '$coupon_id');");
    if ($insert_category > 0) {
        echo "<script>alert('Create category successful!');</script>";
    } else {
        echo "<script>alert('Create category failed!');</script>";
    }
}
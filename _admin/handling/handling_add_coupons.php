<?php

session_start();

if (isset($_POST['add_coupons'])) {
    $coupon_name = $_POST['coupon_name'];
    $discount = $_POST['discount'];

    $insert_category = mysqli_query($con, "INSERT INTO coupons (coupon_name, discount) VALUES ('$coupon_name', '$discount');");
    if ($insert_category > 0) {
        echo "<script>alert('Create coupon successful!');</script>";
    } else {
        echo "<script>alert('Create coupon failed!');</script>";
    }
}
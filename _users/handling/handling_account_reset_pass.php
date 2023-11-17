<?php

session_start();
if (isset($_POST['update_pass'])) {
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $verify_password = $_POST['verify-password'];
    // kiểm tra mật khẩu có đủ mạnh và có khớp với nhau
    if (!empty($new_password) && $new_password != "") {
        if (strlen($new_password) <= '8') {
            echo "<script>alert('Password must be more than 8 characters!');</script>";
        } elseif (!preg_match("#[0-9]+#", $new_password)) {
            echo "<script>alert('Password must contain at least 1 number!');</script>";
        } elseif (!preg_match("#[A-Z]+#", $new_password)) {
            echo "<script>alert('Password must contain at least 1 capital letter!');</script>";
        } elseif (!preg_match("#[a-z]+#", $new_password)) {
            echo "<script>alert('Password must contain at least 1 lowercase letter!');</script>";
        } elseif (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $new_password)) {
            echo "<script>alert('Password must contain at least 1 special letter!');</script>";
        } elseif ($new_password != $verify_password) {
            echo "<script>alert('New passwords don't match!');</script>";
        } elseif ($current_password == $new_password) {
            echo "<script>alert('The old password cannot be the same as the new password!');</script>";
        } else {
            // cập nhật mật khẩu lên database
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentTime = date('Y-m-d H:i:s', time());
            $ret = mysqli_query($con, "UPDATE accounts SET password='$new_password', update_date_account='$currentTime' WHERE account_id='" . $_SESSION['account_id'] . "';");
            if ($ret > 0) {
                echo "<script>alert('Update successful!');</script>";
            } else {
                echo "<script>alert('Update failed!');</script>";
            }
        }
    } else {
        echo "<script>alert('Please enter your new password!');</script>";
    }
}
<?php

session_start();
if (isset($_GET['delete_id'])) {
    $account_id = $_GET['delete_id'];
    $delete_account = mysqli_query($con, "DELETE FROM accounts WHERE account_id=$account_id;");
    $delete_employee = mysqli_query($con, "DELETE FROM employees WHERE account_id=$account_id;");
    if ($delete_account && $delete_employee) {
        echo "<script>alert('Delete account successful!');</script>";
    } else {
        echo "<script>alert('Delete account failed!');</script>";
    }
}

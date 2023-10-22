<?php

session_start();
if (isset($_GET['block_id'])) {
    $account_id = $_GET['block_id'];
    $update_block = mysqli_query($con, "UPDATE accounts SET block=1 WHERE account_id=$account_id;");
    if ($update_block) {
        echo "<script>alert('Block account successful!');</script>";
    } else {
        echo "<script>alert('Block account failed!');</script>";
    }
}
if (isset($_GET['unlock_id'])) {
    $account_id = $_GET['unlock_id'];
    $update_block = mysqli_query($con, "UPDATE accounts SET block=0 WHERE account_id=$account_id;");
    if ($update_block) {
        echo "<script>alert('Unlock account successful!');</script>";
    } else {
        echo "<script>alert('Unlock account failed!');</script>";
    }
}

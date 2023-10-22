<?php

session_start();
if (isset($_GET['delete_id'])) {
    $supplier_id = $_GET['delete_id'];
    $delete_supplier = mysqli_query($con, "DELETE FROM suppliers WHERE supplier_id=$supplier_id;");
    if ($delete_supplier) {
        echo "<script>alert('Delete supplier successful!');</script>";
    } else {
        echo "<script>alert('Delete supplier failed!');</script>";
    }
}
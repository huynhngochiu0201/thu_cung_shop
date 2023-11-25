
<?php

session_start();
include('../../database/connect.php');
mysqli_query($con, "UPDATE count_others SET count_other=count_other-1 WHERE count_other_name='account_online';");
session_destroy();
header("location:../index.php");

<?php

session_start();

// code for login
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['login'])) {
    $email = test_input($_POST['email']);
    // validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $password = test_input($_POST['password']);
        $ret = mysqli_query($con, "SELECT account_id, account_name, avatar, role, block FROM accounts WHERE email='$email' AND password='$password';");
        $num = mysqli_fetch_array($ret);
        if ($num > 0) {
            if ($num['block'] == 0) {
                $_SESSION['account_id'] = $num['account_id'];
                $_SESSION['account_name'] = $num['account_name'];
                $_SESSION['avatar'] = $num['avatar'];
                //count number of online account
                mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='account_online';");
                if($num['role'] == 0) {
                    header("location:index.php");
                } else {
                    header("location:../_admin/index.php");
                }
            } else {
                echo "<script>alert('Your account has been locked!');</script>";
            }
        } else {
            echo "<script>alert('Password or account don't correct!');</script>";
        }
    } else {
        echo "<script>alert('Email not validated!');</script>";
    }
}
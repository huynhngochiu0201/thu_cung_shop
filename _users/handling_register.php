<?php

session_start();

function createAccount($con, $name, $email, $password, $rePassword) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $existingEmail = mysqli_query($con, "SELECT * FROM accounts WHERE email='$email';");
        $num = mysqli_fetch_array($existingEmail);
        if ($num == 0) {
            if (!empty($password) && $password != "") {
                if (strlen($password) <= '6') {
                    return 'Password must be more than 6 characters!';
                } elseif (!preg_match("#[0-9]+#", $password)) {
                    return 'Password must contain at least 1 number!';
                } elseif (!preg_match("#[A-Z]+#", $password)) {
                    return 'Password must contain at least 1 capital letter!';
                } elseif (!preg_match("#[a-z]+#", $password)) {
                    return 'Password must contain at least 1 lowercase letter!';
                } elseif (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
                    return 'Password must contain at least 1 special letter!';
                } elseif ($password != $rePassword) {
                    return "Confirm passwords don't match!";
                } else {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $currentTime = date('Y-m-d H:i:s', time());
                    $insertAccount = mysqli_query($con, "INSERT INTO accounts (account_name, email, password, avatar, role, block) VALUES ('$name', '$email', '$password', 'empty.png', '0', '0');");
                    $queryIdAccount = mysqli_query($con, "SELECT account_id FROM accounts WHERE email='$email';");
                    while ($row = mysqli_fetch_array($queryIdAccount)) {
                        $insertCustomer = mysqli_query($con, "INSERT INTO customers (account_id) VALUES ('" . $row['account_id'] . "');");
                    }
                    $updateCustomer = mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='customers';");
                    if ($insertAccount > 0 && $insertCustomer > 0 && $updateCustomer) {
                        return 'Create account successful!';
                    } else {
                        return 'Create account failed!';
                    }
                }
            } else {
                return 'Please enter your password!';
            }
        } else {
            return 'Email already exists!';
        }
    } else {
        return 'Email invalid!';
    }
}

if (isset($_POST['create_account'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];
    // check validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $ret = mysqli_query($con, "SELECT * FROM accounts WHERE email='$email';");
        $num = mysqli_fetch_array($ret);
        if ($num == 0) {
            if (!empty($password) && $password != "") {
                if (strlen($password) <= '8') {
                    echo "<script>alert('Password must be more than 8 characters!');</script>";
                } elseif (!preg_match("#[0-9]+#", $password)) {
                    echo "<script>alert('Password must contain at least 1 number!');</script>";
                } elseif (!preg_match("#[A-Z]+#", $password)) {
                    echo "<script>alert('Password must contain at least 1 capital letter!');</script>";
                } elseif (!preg_match("#[a-z]+#", $password)) {
                    echo "<script>alert('Password must contain at least 1 lowercase letter!');</script>";
                } elseif (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
                    echo "<script>alert('Password must contain at least 1 special letter!');</script>";
                } elseif ($password != $re_password) {
                    echo "<script>alert('New passwords don't match!');</script>";
                } else {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $currentTime = date('Y-m-d H:i:s', time());
                    //insert a new customer
                    $insert_account = mysqli_query($con, "INSERT INTO accounts (account_name, email, password, avatar, role, block) VALUES ('$name', '$email', '$password', 'empty.png', '0', '0');");
                    $query_id_account = mysqli_query($con, "SELECT account_id FROM accounts WHERE email='$email';");
                    while ($row = mysqli_fetch_array($query_id_account)) {
                        //insert a new customer
                        $insert_customer = mysqli_query($con, "INSERT INTO customers (account_id) VALUES ('" . $row['account_id'] . "');");
                    }
                    //count customers
                    $update_customer = mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='customers';");
                    if ($insert_account > 0 && $insert_customer > 0 && $update_customer) {
                        echo "<script>alert('Create account successful!');</script>";
                    } else {
                        echo "<script>alert('Create account failed!');</script>";
                    }
                }
            } else {
                echo "<script>alert('Please enter your password!');</script>";
            }
        } else {
            echo "<script>alert('Email already exists!');</script>";
        }
    } else {
        echo "<script>alert('Email invalidate!');</script>";
    }
}
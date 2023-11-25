<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function loginUser($con, $email, $password) {
    $email = test_input($email);

    // validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $password = test_input($password);
        $result = mysqli_query($con, "SELECT account_id, account_name, avatar, role, block FROM accounts WHERE email='$email' AND password='$password';");
        $userData = mysqli_fetch_array($result);

        if ($userData > 0) {
            if ($userData['block'] == 0) {
                $_SESSION['account_id'] = $userData['account_id'];
                $_SESSION['account_name'] = $userData['account_name'];
                $_SESSION['avatar'] = $userData['avatar'];

                // count number of online accounts
                mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='account_online';");

                if ($userData['role'] == 0) {
                    return 'index.php';
                } else {
                    return '../_admin/index.php';
                }
            } else {
                return 'Your account has been locked!';
            }
        } else {
            return "Password or account don't correct!";
        }
    } else {
        return 'Email not validated!';
    }
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

class YourLoginClass {

    public function login($con, $postData) {
        if (isset($postData['login'])) {
            $email = $this->validateEmail($postData['email']);
            if ($email !== false) {
                $password = $this->validatePassword($postData['password']);
                $num = $this->performLogin($con, $email, $password);

                if ($num > 0) {
                    // Handle successful login
                    return $this->handleSuccessfulLogin($num);
                } else {
                    // Handle failed login
                    return $this->handleFailedLogin();
                }
            } else {
                // Handle invalid email
                return $this->handleInvalidEmail();
            }
        }
    }

    public function validateEmail($email) {
        $email = test_input($email);
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false ? true : false;
    }

    function isStrongPassword($password) {
        // Kiểm tra độ dài tối thiểu là 6 ký tự
        if (strlen($password) < 6) {
            return false;
        }
    
        // Kiểm tra có ít nhất 1 chữ viết hoa
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
    
        // Kiểm tra có ít nhất 1 ký tự đặc biệt
        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }
    
        // Nếu tất cả điều kiện đều đúng, trả về true
        return true;
    }

    public function validatePassword($password) {
        return test_input($password);
    }

    public function performLogin($con, $email, $password) {
        $ret = mysqli_query($con, "SELECT account_id, account_name, avatar, role, block FROM accounts WHERE email='$email' AND password='$password';");
        return mysqli_fetch_array($ret);
    }



    public function handleSuccessfulLogin($num) {
        if ($num['block'] == 0) {
            $_SESSION['account_id'] = $num['account_id'];
            $_SESSION['account_name'] = $num['account_name'];
            $_SESSION['avatar'] = $num['avatar'];
            mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='account_online';");
            if ($num['role'] == 0) {
                header("location:index.php");
            } else {
                header("location:../_admin/index.php");
            }
        } else {
            echo "<script>alert('Your account has been locked!');</script>";
        }
    }

    public function handleFailedLogin() {
        echo "<script>alert('Password or account don't correct!');</script>";
    }

    public function handleInvalidEmail() {
        echo "<script>alert('Email not validated!');</script>";
    }
}
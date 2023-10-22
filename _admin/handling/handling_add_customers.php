<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['add_customers'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];
    $file_old = test_input($_POST['file_old']);

    $allowUpload = true;
    //Check exist entered picture
    if (strlen($_FILES["avatar"]["name"]) == 0) {
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
                        //count customer
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
    } else {
        //Thư mục bạn sẽ lưu file upload
        $target_dir = "../assets/img/avatars/";

        //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);

        //Lấy phần mở rộng của file (jpg, png, ...)
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        //Cỡ lớn nhất được upload (bytes)
        $maxfilesize = 3000000;

        //Những loại file được phép upload
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif');

        //Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
        //Bạn có thể phát triển code để lưu thành một tên file khác
        if (file_exists($target_file)) {
            unlink('../assets/img/avatars/' . basename($_FILES["avatar"]["name"]));
        }
        //Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
        if ($_FILES["avatar"]["size"] > $maxfilesize) {
            echo "<script>alert('Do not upload images larger than 3mb!');</script>";
            $allowUpload = false;
        }
        //Kiểm tra kiểu file
        if (!in_array($imageFileType, $allowtypes)) {
            echo "<script>alert('Only JPG, PNG, JPEG, GIF formats can be uploaded!');</script>";
            $allowUpload = false;
        }
        if ($allowUpload) {
            //Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
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
                                $insert_account = mysqli_query($con, "INSERT INTO accounts (account_name, email, password, avatar, role, block) VALUES ('$name', '$email', '$password', '" . basename($_FILES["avatar"]["name"]) . "', '0', '0');");
                                $query_id_account = mysqli_query($con, "SELECT account_id FROM accounts WHERE email='$email';");
                                while ($row = mysqli_fetch_array($query_id_account)) {
                                    //insert a new customer
                                    $insert_customer = mysqli_query($con, "INSERT INTO customers (account_id) VALUES ('" . $row['account_id'] . "');");
                                }
                                //count customer
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
            } else {
                echo "An error occurred while updating!";
            }
        } else {
            echo "Unable to update, may be due to large file or incorrect file type!";
        }
    }
}

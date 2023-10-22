<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['account_id'])) {
    $_SESSION['update_by_id'] = $_GET['account_id'];
}

if (isset($_POST['update'])) {
    $account_name = test_input($_POST['account_name']);
    $account_address = test_input($_POST['account_address']);
    $employee_position = test_input($_POST['employee_position']);

    $gender = test_input($_POST['gender']);
    $phone = test_input($_POST['phone']);
    $date_of_birth = test_input($_POST['date_of_birth']);
    $file_old = test_input($_POST['file_old']);

    $allowUpload = true;
    //Check exist entered picture
    if (strlen($_FILES["avatar"]["name"]) == 0) {
        if (preg_match('/^[0-9]+$/', $phone) || $phone == '') {
            if (preg_match('/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/', $date_of_birth) || $date_of_birth == '') {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentTime = date('Y-m-d H:i:s', time());

                $update_account = mysqli_query($con, "UPDATE accounts SET account_name='$account_name', date_of_birth='$date_of_birth', account_address='$account_address', avatar='$file_old', "
                        . "phone='$phone', gender='$gender', update_date_account='$currentTime' WHERE account_id=" . $_SESSION['update_by_id'] . ";");
                $update_employee = mysqli_query($con, "UPDATE employees SET employee_position='$employee_position' WHERE account_id=" . $_SESSION['update_by_id'] . ";");

                if ($update_account && $update_employee) {
                    echo "<script>alert('Update account successful!');</script>";
                } else {
                    echo "<script>alert('Update account failed!');</script>";
                }
            } else {
                echo "<script>alert('Date of birth is not correct!');</script>";
            }
        } else {
            echo "<script>alert('Phone number is not correct!');</script>";
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
                if (preg_match('/^[0-9]+$/', $phone) || $phone == '') {
                    if (preg_match('/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/', $date_of_birth) || $date_of_birth == '') {
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $currentTime = date('Y-m-d H:i:s', time());

                        $update_account = mysqli_query($con, "UPDATE accounts SET account_name='$account_name', date_of_birth='$date_of_birth', account_address='$account_address', avatar='" . basename($_FILES["avatar"]["name"]) . "', "
                                . "phone='$phone', gender='$gender', update_date_account='$currentTime' WHERE account_id=" . $_SESSION['update_by_id'] . ";");
                        $update_employee = mysqli_query($con, "UPDATE employees SET employee_position='$employee_position' WHERE account_id=" . $_SESSION['update_by_id'] . ";");

                        if ($update_account && $update_employee) {
                            echo "<script>alert('Update account successful!');</script>";
                        } else {
                            echo "<script>alert('Update account failed!');</script>";
                        }
                    } else {
                        echo "<script>alert('Date of birth is not correct!');</script>";
                    }
                } else {
                    echo "<script>alert('Phone number is not correct!');</script>";
                }
            } else {
                echo "An error occurred while updating!";
            }
        } else {
            echo "Unable to update, may be due to large file or incorrect file type!";
        }
    }
}
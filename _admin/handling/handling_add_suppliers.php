<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['add_suppliers'])) {
    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_address = $_POST['supplier_address'];
    $supplier_phone = $_POST['supplier_phone'];

    $allowUpload = true;
    //Check exist entered picture
    if (strlen($_FILES["avatar"]["name"]) == 0) {
        if (!filter_var($supplier_email, FILTER_VALIDATE_EMAIL) === false) {
            $ret = mysqli_query($con, "SELECT * FROM suppliers WHERE supplier_email='$supplier_email';");
            $num = mysqli_fetch_array($ret);
            if ($num == 0) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentTime = date('Y-m-d H:i:s', time());
                //insert a new suppliers
                $insert_supplier = mysqli_query($con, "INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone, supplier_avatar) VALUES ('$supplier_name', '$supplier_email', '$supplier_address', '$supplier_phone', 'empty.png');");
                //count supplier
                $update_supplier = mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='suppliers';");
                if ($insert_supplier > 0 && $update_supplier) {
                    echo "<script>alert('Create supplier successful!');</script>";
                } else {
                    echo "<script>alert('Create supplier failed!');</script>";
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
                if (!filter_var($supplier_email, FILTER_VALIDATE_EMAIL) === false) {
                    $ret = mysqli_query($con, "SELECT * FROM suppliers WHERE supplier_email='$supplier_email';");
                    $num = mysqli_fetch_array($ret);
                    if ($num == 0) {
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $currentTime = date('Y-m-d H:i:s', time());
                        //insert a new suppliers
                        $insert_supplier = mysqli_query($con, "INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone, supplier_avatar) VALUES ('$supplier_name', '$supplier_email', '$supplier_address', '$supplier_phone', '" . basename($_FILES["avatar"]["name"]) . "');");
                        //count supplier
                        $update_supplier = mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='suppliers';");
                        if ($insert_supplier > 0 && $update_supplier) {
                            echo "<script>alert('Create supplier successful!');</script>";
                        } else {
                            echo "<script>alert('Create supplier failed!');</script>";
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

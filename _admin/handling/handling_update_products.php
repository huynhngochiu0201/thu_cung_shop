<?php

//chưa xong
session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['product_id'])) {
    $_SESSION['update_by_id'] = $_GET['product_id'];
}

if (isset($_POST['update'])) {
    $product_name = test_input($_POST['product_name']);
    $product_type_id = test_input($_POST['product_type_id']);
    $brand = test_input($_POST['brand']);
    $product_quantity = test_input($_POST['product_quantity']);
    $product_description = test_input($_POST['product_description']);
    $product_price = test_input($_POST['product_price']);

    $check_update_success = true;

    $update_product_basic = mysqli_query($con, "UPDATE products SET product_name='$product_name', product_type_id='$product_type_id', brand='$brand', product_quantity=product_quantity+'$product_quantity', "
            . "product_description='$product_description', product_price='$product_price' WHERE product_id=" . $_SESSION['update_by_id'] . ";");
    if (!$update_product_basic) {
        $check_update_success = false;
    }


    for ($i = 1; $i <= 3; $i++) {
        $file_old_string = 'file_old_' . $i;
        $avatar = 'avatar_' . $i;
        $allowUpload = true;

        $file_old = test_input($_POST[$file_old_string]);
        //Check exist entered picture
        if (strlen($_FILES[$avatar]["name"]) == 0) {

            $update_product = mysqli_query($con, "UPDATE products SET product_image_$i='$file_old' WHERE product_id=" . $_SESSION['update_by_id'] . ";");
            if (!$update_product) {
                $check_update_success = false;
            }
        } else {
            //Thư mục bạn sẽ lưu file upload
            $target_dir = "../assets/img/image_products/";

            //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
            $target_file = $target_dir . basename($_FILES[$avatar]["name"]);

            //Lấy phần mở rộng của file (jpg, png, ...)
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            //Cỡ lớn nhất được upload (bytes)
            $maxfilesize = 3000000;

            //Những loại file được phép upload
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif');

            //Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
            //Bạn có thể phát triển code để lưu thành một tên file khác
            if (file_exists($target_file)) {
                unlink('../assets/img/image_products/' . basename($_FILES[$avatar]["name"]));
            }
            //Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
            if ($_FILES[$avatar]["size"] > $maxfilesize) {
                $allowUpload = false;
            }
            //Kiểm tra kiểu file
            if (!in_array($imageFileType, $allowtypes)) {
                $allowUpload = false;
            }
            if ($allowUpload) {
                //Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
                if (move_uploaded_file($_FILES[$avatar]["tmp_name"], $target_file)) {
                    //update image
                    $update_product = mysqli_query($con, "UPDATE products SET product_image_$i='" . basename($_FILES[$avatar]["name"]) . "' WHERE product_id=" . $_SESSION['update_by_id'] . ";");
                    if (!$update_product) {
                        $check_update_success = false;
                    }
                } else {
                    $check_update_success = false;
                }
            } else {
                $check_update_success = false;
            }
        }
    }
    if ($check_update_success) {
        echo "<script>alert('Update product successful!');</script>";
    } else {
        echo "<script>alert('Update product failed!');</script>";
    }
}
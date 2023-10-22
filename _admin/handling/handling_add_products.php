<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['add_products'])) {
    $product_name = $_POST['product_name'];
    $product_type_id = $_POST['product_type_id'];
    $brand = $_POST['brand'];
    $product_quantity = $_POST['product_quantity'];
    $product_description = test_input($_POST['product_description']);
    $product_price = $_POST['product_price'];

    $check_update_success = true;

    $insert_product = mysqli_query($con, "INSERT INTO products (product_name, product_type_id, brand, product_quantity, product_description, product_price) VALUES ('$product_name', '$product_type_id', '$brand', '$product_quantity', '$product_description', '$product_price');");

    //count product
    $update_product = mysqli_query($con, "UPDATE count_others SET count_other=count_other+1 WHERE count_other_name='products';");
    if (!$insert_product > 0 && $update_product) {
        $check_update_success = false;
    }

    $query_id_product = mysqli_query($con, "SELECT product_id FROM products WHERE product_name='$product_name';");
    while ($row = mysqli_fetch_array($query_id_product)) {

        $insert_product_count = mysqli_query($con, "INSERT INTO count_sales (product_id, count_sale) VALUES ('" . $row['product_id'] . "', 0);");
        if (!$insert_product_count > 0) {
            $check_update_success = false;
        }

        for ($i = 1; $i <= 3; $i++) {
            $avatar = 'avatar_' . $i;
            $allowUpload = true;

            //Check exist entered picture
            if (strlen($_FILES[$avatar]["name"]) == 0) {

                $update_product = mysqli_query($con, "UPDATE products SET product_image_$i='empty_product.png' WHERE product_id=" . $row['product_id'] . ";");
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
                        $update_product = mysqli_query($con, "UPDATE products SET product_image_$i='" . basename($_FILES[$avatar]["name"]) . "' WHERE product_id=" . $row['product_id'] . ";");
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
    }
    if ($check_update_success) {
        echo "<script>alert('Update product successful!');</script>";
    } else {
        echo "<script>alert('Update product failed!');</script>";
    }
}
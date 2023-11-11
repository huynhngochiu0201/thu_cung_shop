<?php
include('../database/connect.php');
include('handling/handling_checkout.php');
if (!isset($_SESSION['account_id'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link href="../assets/img/others/logo_mini.png" rel="icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Bootstrap -->

    <link rel="stylesheet" href="../assets/css/users/footer.css"> 
    <link rel="stylesheet" href="../assets/css/users/header.css"> 
    <link rel="stylesheet" href="../assets/css/users/checkout.css"> 
    <title>Checkout</title>
</head>
<header>
    <?php
    include('nav.php');
    ?>
</header>
<body>  
    <div class=".container-fluid">
        <!-- banner -->
        <div class="banner">
            <img src="../assets/img/others/banner-checkout.png" alt="checkout-banner">
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php
            $quantity = 0;
            $total = 0;
            $order_product_all_id = '';
            $order_all_quantity = '';
            if (!isset($_GET['product_id'])) {
                //use to choose cart delete
                $_SESSION['delete_cart'] = 1;

                //take the product information to checkout
                $infor_product = "products.product_id, product_name, product_price, discount, cart_quantity";
                $table_link = "products, product_types, coupons, carts";
                $link = "products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND carts.product_id=products.product_id";
                $query_product_checkout = mysqli_query($con, "SELECT $infor_product FROM $table_link WHERE $link AND account_id=" . $_SESSION['account_id'] . ";");
            } else {
                //use to choose cart delete
                $_SESSION['delete_cart'] = 0;

                //take the product information to checkout with one product
                $GLOBALS['quantity'] = $_GET['cart_quantity'];
                $GLOBALS['order_product_all_id'] = $_GET['product_id'] . ",";
                $infor_product = "products.product_id, product_name, product_price, discount";
                $table_link = "products, product_types, coupons";
                $link = "products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id";
                $query_product_checkout = mysqli_query($con, "SELECT $infor_product FROM $table_link WHERE $link AND products.product_id=" . $_GET['product_id'] . ";");
            }
            $info_account = "account_id, account_name, email, account_address, phone";
            $query_account = mysqli_query($con, "SELECT $info_account FROM accounts WHERE account_id=" . $_SESSION['account_id'] . ";");
            $row_account = mysqli_fetch_array($query_account);
            ?>
            <div class="row checkout__page">
                <div class="col-md-6">
                    <div class="section__title">Bill Detail</div>
                    <!-- Name -->
                    <div class="input__field">
                        <div class="input__field__title">Your name*</div>
                        <input type="text" name="order_name" placeholder="Your name" value="<?php echo htmlentities($row_account['account_name']); ?>" required>
                        <!--<div class="text-danger">
                            Dòng nãy sẽ hiện lên khi khách hàng không nhập thông tin
                        </div>-->
                    </div>
                    <!-- email input -->
                    <div class="input__field">
                        <div class="input__field__title">Your email*</div>
                        <input type="text" value="<?php echo htmlentities($row_account['email']); ?>" disabled>
                    </div>
                    <!-- select country
                    <div class="input__field">
                        <div class="input__field__title">Province/City*</div>
                        <select class="input__field__selector" name="order_address_province">
                            <option selected>Choose Province</option>
                            <option value="An Giang">An Giang</option>
                            <option value="Bà Rịa Vũng Tàu">Bà Rịa Vũng Tàu</option>
                            <option value="Bạc Liêu">Bạc Liêu</option>
                            <option value="Bắc Giang">Bắc Giang</option>
                            <option value="Bắc Kạn">Bắc Kạn</option>
                            <option value="Bắc Ninh">Bắc Ninh</option>
                            <option value="Bình Dương">Bình Dương</option>
                            <option value="Bình Định">Bình Định</option>
                            <option value="Bình Phước">Bình Phước</option>
                            <option value="Bình Thuận">Bình Thuận</option>
                            <option value="Cà Mau">Cà Mau</option>
                            <option value="Cao Bằng">Cao Bằng</option>
                            <option value="Cần Thơ">Cần Thơ</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Đắk Lắk">Đắk Lắk</option>
                            <option value="Đắk Nông">Đắk Nông</option>
                            <option value="Điện Biên">Điện Biên</option>
                            <option value="Đồng Nai">Đồng Nai</option>
                            <option value="Đồng Tháp">Đồng Tháp</option>
                            <option value="Gia Lai">Gia Lai</option>
                            <option value="Hà Giang">Hà Giang</option>
                            <option value="Hà Nam">Hà Nam</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Hà Tĩnh">Hà Tĩnh</option>
                            <option value="Hải Dương">Hải Dương</option>
                            <option value="Hải Phòng">Hải Phòng</option>
                            <option value="Hậu Giang">Hậu Giang</option>
                            <option value="Hòa Bình">Hòa Bình</option>
                            <option value="TP. Hồ Chí Minh">Thành phố Hồ Chí Mính</option>
                            <option value="Huế">Huế</option>
                            <option value="Hưng Yên">Hưng Yên</option>
                            <option value="Kiên Giang">Kiên Giang</option>
                            <option value="Khánh Hòa">Khánh Hòa</option>
                            <option value="Hưng Yên">Hưng Yên</option>
                            <option value="Nha Trang">Nha Trang</option>
                            <option value="Huế">Huế</option>
                            <option value="Sóc Trăng">Sóc Trăng</option>
                            <option value="Sơn La">Sơn La</option>
                            <option value="Thái Nguyên">Thái Nguyên</option>
                            <option value="Thanh Hóa">Thanh Hóa</option>
                            <option value="Trà Vinh">Trà Vinh</option>
                            <option value="Tuyên Quang">Tuyên Quang</option>
                            <option value="Trà Giang">Trà Giang</option>
                            <option value="Vĩnh Long">Vĩnh Long</option>
                            <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                            <option value="Yên Bái">Yên Bái</option>
                        </select>
                    </div>-->
                    <!-- street address -->
                    <div class="input__field">
                        <div class="input__field__title">Street Address*</div>
                        <input type="text" name="order_address" placeholder="Street Address" value="<?php echo htmlentities($row_account['account_address']); ?>">
                    </div>
                    <div class="input__field">
                        <div class="input__field__title">Phone*</div>
                        <input type="text" name="order_phone" placeholder="Phone" value="<?php echo htmlentities($row_account['phone']); ?>">
                    </div>

                    <div class="input__field">
                        <div class="input__field__title">Order note (optional)</div>
                        <textarea class="input__field__textarea" name="order_notes" placeholder="Write something"></textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-5">
                    <div class="section__title">Your Order</div>
                    <div class="border__order">
                        <table class="table table-condensed">
                            <tr>
                                <th>Product</th>
                                <th>Number</th>
                                <th>Subtotal</th>
                            </tr>
                            <?php
                            while ($row_product = mysqli_fetch_array($query_product_checkout)) {
                                if (!isset($_GET['product_id'])) {
                                    $GLOBALS['quantity'] = $row_product['cart_quantity'];
                                    $GLOBALS['order_product_all_id'] .= $row_product['product_id'] . ',';
                                } else {
                                    $GLOBALS['order_product_all_id'] = $_GET['product_id'] . ",";
                                }
                                //take the quantity of check out to push in your orders
                                $GLOBALS['order_all_quantity'] .= $GLOBALS['quantity'] . ',';
                                $GLOBALS['total'] += ($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $GLOBALS['quantity'];
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($row_product['product_name']); ?></td>
                                    <td><?php echo htmlentities($GLOBALS['quantity']); ?></td>
                                    <td>$<?php echo htmlentities(($row_product['product_price'] - ($row_product['product_price'] * ($row_product['discount'] / 100))) * $GLOBALS['quantity']); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <hr class="line">
                        <div class="body__order__row">
                            <b>Sub-Total</b>
                            <div>$<?php echo $total; ?></div>
                        </div>
                        <hr class="line">
                        <div class="body__order__row">
                            <b>
                                <b class="body__ordershipping">SHIPPING</b>
                                <div class="body_ordershipping__type">COD - Cash On Delivery</div>
                            </b>
                            <div>$2</div>
                        </div>
                        <hr class="line">
                        <div class="body__order__row">
                            <b>TOTAL</b>
                            <b class="body__ordertotal__total ">$<?php echo $total + 2; ?></b>
                        </div>
                        <hr class="line">
                        <div>
                            <input name="order_product_all_id" type="hidden" value="<?php echo $order_product_all_id; ?>">
                            <input name="order_all_quantity" type="hidden" value="<?php echo $order_all_quantity; ?>">
                        </div>
                        <div class="placeorder">
                            <input name="orders" type="submit" value="Place Order" type="submit" class="btn placeorder--btn">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('#burger-top').click(() => {
                // $(".modal-overlay").show();
                $('#burger-top').css('display', 'none');
                $('#close-top').css('display', 'inline-block');
                $(".panel").slideToggle();
            });

            $('#close-top').click(() => {
                $('#burger-top').css('display', 'inline-block');
                $('#close-top').css('display', 'none');
                $(".panel").slideToggle();
            });

            // Shopping cart dropdown
            $('#topnav__item__cart').click(() => {
                $('.cart__dropdown').slideDown();

            });

            $(document).click(function (e) {
                if ($(e.target).is('.cart__dropdown, #topnav__item__cart *'))
                    return;
                $('.cart__dropdown').slideUp();
            });


            // $('#topnav__item__cart').click(() => {
            //     $('.cart__dropdown').slideUp();
            // })

            //Sticky navbar
            const navbarOffset = $('.navbar__topnav').offset();
            window.onscroll = function () {
                StickNavBar(navbarOffset.top)
            };

            // console.log(offset.top);
        });


        function StickNavBar(navbarOffset) {
            if (window.pageYOffset >= 80) {
                $('.navbar__topnav').addClass('navbar__topnav-sticky ');
                $(".panel").addClass('panel-stickey');

            } else {
                $('.navbar__topnav').removeClass('navbar__topnav-sticky ');
                $(".panel").removeClass('panel-stickey');

            }
        }

        function RemoveDropDownItem(id) {
            $.ajax({
                url: '/cart/remove/' + id,
                type: 'GET'
            }).done(function (response) {
                RemoveItemInCart(response);
            });
        }

        function RemoveItemInCart(response) {
            var newDropDownItems = $('.cart__dropdown__list', $($.parseHTML(response)));
            if (newDropDownItems) {
                $('.cart__dropdown__list').empty();
                $('.cart__dropdown__list').append(newDropDownItems);
            }

            var newCartItems = $('#changing-cart', $($.parseHTML(response)));
            if (newCartItems) {
                $('#changing-cart').empty();
                $('#changing-cart').append(newCartItems);
            }
        }
    </script>
</body>
</html>
<?php
include('../database/connect.php');
include('handling/handling_page_carts.php');
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
    <link rel="stylesheet" href="../assets/css/users/shoppingcart.css">  
    <title>Document</title>
</head>
<header>
    <?php
    include('nav.php');
    ?>
</header>
<body>
    <div class=".container-fluid">
        <div class="banner">
            <img src="../assets/img/others/banner-cart.png" alt="contact-banner">
        </div>
        <!-- thanh dieu huong -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ml-5"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </nav>
        <h3 class="text-center mb-5">YOUR CART ITEMS</h3>
        <!-- tieu de -->
        <div class="cart__container">
            <div class="cart row p-3 mb-2">
                <div class="cart__title  col-md-2">
                    Image
                </div>
                <div class="cart__title  col-md-3">
                    Name
                </div>
                <div class="cart__title col-md-2">
                    Price
                </div>
                <div class="cart__title col-md-2">
                    Quantity
                </div>
                <div class="cart__title col-md-2">
                    Subtotal
                </div>
                <div class="cart__title col-md-1">Delete</div>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div id="changing-cart">
                    <?php
                    $total = 0;
                    $infor_product = "products.product_id, product_name, product_price, product_image_1, discount, cart_quantity, product_quantity";
                    $table = "products, product_types, coupons, carts";
                    $link = "products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND carts.product_id=products.product_id";
                    $query_carts = mysqli_query($con, "SELECT " . $infor_product . " FROM $table WHERE $link AND account_id=" . $_SESSION['account_id'] . ";");
                    while ($row = mysqli_fetch_array($query_carts)) {
                        $GLOBALS['total'] += (($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))) * $row['cart_quantity']);
                        ?>
                        <div class="row">
                            <div class="product__set col-md-2">
                                <a href="product_detail.php?product_id=<?php echo htmlentities($row['product_id']); ?>"> <img class="product__set--image" id="image" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" /></a>
                            </div>

                            <div class="product__property product__name col-md-3">
                                <a href="product_detail.php?product_id=<?php echo htmlentities($row['product_id']); ?>" class="product__name"><?php echo htmlentities($row['product_name']); ?></a>
                            </div>
                            <div class="product__property col-md-2">
                                <del class="mr-2">$<?php echo htmlentities($row['product_price']); ?></del> <strong>$<?php echo htmlentities(round($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100)), 2)); ?></strong>
                            </div>
                            <div class="product__property col-md-2">
                                <div class="buttons_added">
                                    <input name="product_<?php echo htmlentities($row['product_id']); ?>" type="hidden" value="<?php echo htmlentities($row['product_id']); ?>">
                                    <input class="minus is-form" type="button" value="-" onclick="DecreaseQuantity(<?php echo htmlentities($row['product_id']); ?>)">
                                    <input aria-label="quantity" name="cart_quantity_<?php echo htmlentities($row['product_id']); ?>" class="input-qty input-qty-value<?php echo htmlentities($row['product_id']); ?>" max="<?php echo htmlentities($row['product_quantity']); ?>" min="1" value="<?php echo htmlentities($row['cart_quantity']); ?>" type="number">
                                    <input class="plus is-form" type="button" value="+" onclick="IncreaseQuantity(<?php echo htmlentities($row['product_id']); ?>)">
                                </div>
                            </div>
                            <div class="product__property col-md-2">
                                $<?php echo htmlentities(round(($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))) * $row['cart_quantity'], 2)); ?>
                            </div>
                            <a href="page_carts.php?delete=delete&product_id=<?php echo htmlentities($row['product_id']); ?>" class="product__property btn__bin col-md-1">
                                <i class="bin--icon fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <hr class="line my-3 ">
                <div class="row btn__cart ">
                    <div class="overlay__btn mr-3">
                        <button class="btn__main">
                            <a href="page_product.php?next_page=0">Continue Shopping</a>
                        </button>
                    </div>
                    <div class="overlay__btn">
                        <button name="update_carts" class="btn__main" type="submit">Update Cart</button>
                    </div>
                </div>
            </form>
            <hr class="line my-3 ">
            <div class="container-fluid">
                <p class="carttotal">Cart Total</p>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>$<?php echo round($total, 2); ?></td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <th>Shipping</th>
                            <td>COD - Cash On Delivery</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <th>Total</th>
                            <td>$<?php echo round($total + 2, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn__cart">
                    <div class="overlay__btn">
                        <button class="btn__main">
                            <a href="checkout.php">Procceed to payment</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <script>
        const DecreaseQuantity = (id) => {
            let quantity = $('.input-qty-value' + id).attr('value');
            if (Number(quantity) - 1 > 0) {
                quantity = Number(quantity) - 1;
                $('.input-qty-value' + id).attr('value', quantity);
            }
        };
        const IncreaseQuantity = (id) => {
            let quantity = $('.input-qty-value' + id).attr('value');
            quantity = Number(quantity) + 1;
            $('.input-qty-value' + id).attr('value', quantity);
        };
    </script>
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
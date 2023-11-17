<?php
include('../database/connect.php');
include('handling/handling_product_detail.php');
if (!isset($_GET['product_id'])) {
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
    <link rel="stylesheet" href="../assets/css/users/product_detail.css">  
    <title>Product Detail</title>
</head>
<header>
    <?php
    include('nav.php');
    ?>
</header>
<body>
    <?php
    //take product detail
    $infor_product = "product_id, products.product_type_id, product_name, product_quantity, product_price, product_description, product_image_1, product_image_2, product_image_3, discount, product_type_name";
    $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND product_id=" . $_GET['product_id'] . ";");
    while ($row = mysqli_fetch_array($query_products)) {
        ?>
        <!-------------breadcrumb------------->
        <nav aria-label="breadcrumb breadcrumb--container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item ml-5"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                <li class="breadcrumb-item"><a href="page_product.php?next_page=0">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlentities($row['product_name']); ?></li>
            </ol>
        </nav>
        <!----------Product Content---------->
        <div class="prod-content container-fluid">
            <div class="prod-content__row row justify-content-center">
                <!--3 Mini Photos -->
                <div class="mini-photos__warrper col-md-2">

                    <img id="slideLeft" class="arrow" src="../assets/img/others/arrow-left.png">
                    <img id="slideTop" class="arrow" src="../assets/img/others/arrow-top.png">            
                    <div class="mini-photos__row  ">
                        <?php if ($row['product_image_1'] != '') { ?>
                            <div class="mini-photo__col ">
                                <img class="thumbnail active" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" alt="">
                            </div>
                        <?php } ?>
                        <?php if ($row['product_image_2'] != '') { ?>
                            <div class="mini-photo__col ">
                                <img class="thumbnail active" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_2']); ?>" alt="">
                            </div>
                        <?php } ?>
                        <?php if ($row['product_image_3'] != '') { ?>
                            <div class="mini-photo__col ">
                                <img class="thumbnail active" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_3']); ?>" alt="">
                            </div>
                        <?php } ?>
                    </div>
                    <img id="slideRight" class="arrow" src="../assets/img/others/arrow-right.png">
                    <img id="slideBottom" class="arrow" src="../assets/img/others/arrow-bottom.png">
                </div>
                <!-- Big Photo -->
                <div class="prod-content__col--big col-md-6 ">
                    <img class="big-photo--imageradius featured" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" />
                </div>

                <!--Short Product Description-->
                <div class="product-desc__col col-md-4">
                    <p class="product-desc--name h5"> <strong><?php echo htmlentities($row['product_name']); ?></strong> </p>
                    <del class="h7">$<?php echo htmlentities($row['product_price']); ?></del>
                    <strong class="product-desc--price  ">$<?php echo htmlentities(round($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100)), 2)); ?></strong>
                    <div class="product-desc--detail">
                        <p class="h7"><?php echo substr(html_entity_decode($row['product_description']), 0, 40); ?>...</p>
                    </div>
                    <?php if ($row['product_quantity'] != 0) { ?>
                        <form method="get" action="page_carts.php">
                            <input type="hidden" name="product_id" value="<?php echo htmlentities($row['product_id']); ?>">
                            <div>
                                <div class="buttons_added">
                                    <input class="minus is-form" type="button" value="-" onclick="DecreaseQuantity()">
                                    <input aria-label="quantity" name="cart_quantity" class="input-qty" max="<?php echo htmlentities($row['product_quantity']); ?>" min="1" value="1" type="number">
                                    <input class="plus is-form" type="button" value="+" onclick="IncreaseQuantity()">
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="add" value="add" class="btn-product btn--addCart">Add to cart</button>
                            <button type="submit" name="checkout" value="checkout" class="btn-product btn--buyNow">Buy Now</button>
                        </form>
                    <?php } else { ?>
                        <div class="product-desc--category">
                            <p class="product-desc__h7 h7">
                                <strong>The product is out of stock</strong>
                            </p>
                        </div>
                    <?php } ?>
                    <div class="product-desc--category">
                        <p class="product-desc__h7 h7">
                            <strong>Category:</strong>
                            <span class="product-desc__h7--name"><?php echo htmlentities($row['product_type_name']); ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--------Detail description------------>
        <div class="product-detail__row row mt-5 ml-4">
            <div class="product-detail__col--des col col-sm-9">

                <div class="product-detail--title">
                    <h4>Product Description</h5>
                </div>
                <!-- detail description p -->
                <div class="product-detail--desc">
                    <?php echo html_entity_decode($row['product_description']); ?>
                </div>

            </div>
            <!--Trending Product-->
            <div class=" advertise bouncing col col-md-3">
                <img src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" alt="">
            </div>
        </div>

        <!--
        <p class="comment">Comment and review of customer</p>
        <div class="comment_detail"></div> -->

        <!-----------Related Products-------------->
        <div class="related-prod">
            <!-- title -->
            <div class="related-prod__h3">
                <p class="h3 text-center">Related Products</p>
            </div>
            <!-- Related product's content -->
            <div class="related-prod__row row justify-content-center">
                <?php
                //take product related
                $infor_product_relate = "product_id, product_name, product_price, product_image_1, discount";
                $query_product_relate = mysqli_query($con, "SELECT " . $infor_product_relate . " FROM products, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND products.product_type_id=" . $row['product_type_id'] . " AND product_id!=" . $row['product_id'] . " LIMIT 3;");
                while ($row_pro_relate = mysqli_fetch_array($query_product_relate)) {
                    ?>
                    <div class="row">
                        <a href="product_detail.php?product_id=<?php echo htmlentities($row_pro_relate['product_id']); ?>" class="related-prod__col col">
                            <img src="../assets/img/image_products/<?php echo htmlentities($row_pro_relate['product_image_1']); ?>" alt="">
                            <p class="related-prod__h6--name h6 text-center"><?php echo htmlentities($row_pro_relate['product_name']); ?></p>
                            <p class="related-prod__h6--price h6 text-center"><del>$<?php echo htmlentities($row_pro_relate['product_price']); ?></del> <strong>$<?php echo htmlentities(round($row_pro_relate['product_price'] - ($row_pro_relate['product_price'] * ($row_pro_relate['discount'] / 100)), 2)); ?></strong></p>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <script>
        // Danh cho quantity input
        let quantity = $(".input-qty").attr("value");

        const DecreaseQuantity = () => {
            if (Number(quantity) - 1 > 0) {
                quantity = Number(quantity) - 1;
                $(".input-qty").attr("value", quantity);
            }
        };

        const IncreaseQuantity = () => {
            quantity = Number(quantity) + 1;
            $(".input-qty").attr("value", quantity);
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
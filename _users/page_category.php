<?php
include('../database/connect.php');
include('handling/handling_index.php');
if (!isset($_GET['product_type_id'])) {
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
    <link rel="stylesheet" href="../assets/css/users/page_product.css">  
    <title>Page Category</title>
</head>
<header>
    <?php
    include('nav.php');
    ?>
</header>
<body>
    <div class=".container-fluid">
        <div class="shop">
            <img id="banner" src="../assets/img/others/banner.png">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item ml-5"><i class="fas fa-home" aria-hidden="true"></i></li>
                    <li class="breadcrumb-item active" aria-current="page">Category</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mt-5 ml-4">
        <br><br>
        <div class="grid-container" style="align-items: center">
            <?php
            $infor_product_category = "product_id, product_name, product_price, product_image_1, discount";
            $query_products = mysqli_query($con, "SELECT " . $infor_product_category . " FROM products, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND product_types.product_type_id=" . $_GET['product_type_id'] . ";");
            while ($row = mysqli_fetch_array($query_products)) {
                ?>
                <a href="product_detail.php?product_id=<?php echo htmlentities($row['product_id']); ?>" class="product-content">
                    <div class="imageproduct text-center"><img class="radius-product" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>"/>
                        <div class="productname text-center mt-2"><?php echo htmlentities($row['product_name']); ?></div>
                    </div>
                    <div>
                        <del class="margimobile">$<?php echo htmlentities($row['product_price']); ?></del>
                        <strong>$<?php echo htmlentities(round($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100)), 2)); ?></strong>
                    </div>
                </a>
            <?php } ?>
        </div>
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
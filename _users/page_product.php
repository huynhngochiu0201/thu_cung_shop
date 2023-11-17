<?php
include('../database/connect.php');
include('handling/handling_page_product.php');
if (!isset($_GET['next_page']) && !isset($_POST['search'])) {
    header("location:login.php");
}
if (isset($_POST['search'])) {
    $_GET['next_page'] = 0;
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
    <title>Page Product</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- search button -->
    <div class="row mt-5 ml-4">
        <div class="col-sm-3">
            <div class="ml-2">
                <div class="inputWithIcon">
                    <div>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input name="keyword" type="text" placeholder="Search..." class="searchbtn py-1 border" id="searchbtn">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <button name="search" type="submit" hidden></button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <!-- categorties -->
            <div class="categorties ml-2">
                <div class="titleCategorties mb-3 font-weight-bold">Categories</div>
                <div class="contentCategorties">
                    <?php
                    $query_categorys = mysqli_query($con, "SELECT product_type_id, product_type_name FROM product_types;");
                    while ($row = mysqli_fetch_array($query_categorys)) {
                        ?>
                        <div>
                            <a href="page_category.php?product_type_id=<?php echo htmlentities($row['product_type_id']); ?>" class="content mb-2"><?php echo htmlentities($row['product_type_name']); ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>        
            <!--Trending product-->
            <div class="trending mt-4 ml-2">
                <div class="titleTrending mb-3 font-weight-bold">
                    Trending product
                </div>
                <?php
                $infor_product = "products.product_id, product_name, product_price, product_image_1, discount";
                $query_trending_product = mysqli_query($con, "SELECT " . $infor_product . " FROM products, count_sales, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND count_sales.product_id=products.product_id ORDER BY count_sale DESC LIMIT 3;");
                while ($row = mysqli_fetch_array($query_trending_product)) {
                    ?>
                    <div class="trendingproduct name">
                        <div class="trendingname">
                            <a href="product_detail.php?product_id=<?php echo htmlentities($row['product_id']); ?>">
                                <div>
                                    <div><img class="imageradius" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" /></div>
                                </div>
                                <div class="contentTrending">
                                    <div><?php echo htmlentities(substr($row['product_name'], 0, 25)); ?>...</div>
                                    <del class="margimobile">$<?php echo htmlentities($row['product_price']); ?></del>
                                    <strong>$<?php echo htmlentities(round($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100)), 2)); ?></strong>
                                </div>
                            </a>
                        </div>
                        <hr class="my-3">
                    </div>
                <?php } ?>
            </div>
        </div>

        <!---product-->
        <div class="col-sm-9">
            <br><br>
            <div class="grid-container">
                <?php if (!isset($_POST['search']) || (isset($_POST['search']) && empty($_POST['keyword']))) { ?>
                    <?php
                    $infor_products = "product_id, product_name, product_price, product_image_1, discount";
                    $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id LIMIT 9 OFFSET " . $_GET['next_page'] * 9 . ";");
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
                <div style="text-align: center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="page_product.php?next_page=<?php echo $_GET['next_page'] - 1; ?>">Previous</a></li>
                        <?php if ($_GET['next_page'] > 0) { ?>
                            <li class="page-item"><a class="page-link" href="page_product.php?next_page=<?php echo $_GET['next_page'] - 1; ?>"><?php echo $_GET['next_page']; ?></a></li>
                        <?php } ?>
                        <li class="page-item active"><a class="page-link" href="page_product.php?next_page=<?php echo $_GET['next_page']; ?>"><?php echo $_GET['next_page'] + 1; ?></a></li>
                        <li class="page-item"><a class="page-link" href="page_product.php?next_page=<?php echo $_GET['next_page'] + 1; ?>"><?php echo $_GET['next_page'] + 2; ?></a></li>
                        <?php if ($_GET['next_page'] == 0) { ?>
                            <li class="page-item"><a class="page-link" href="page_product.php?next_page=<?php echo $_GET['next_page'] + 2; ?>"><?php echo $_GET['next_page'] + 3; ?></a></li>
                        <?php } ?>  
                        <li class="page-item"><a class="page-link" href="page_product.php?next_page=<?php echo $_GET['next_page'] + 1; ?>">Next</a></li>
                    </ul>
                </div>


                <!--
                                <div class="nextpage1">          
                                    <ul class="pagination">
                <?php //if ($_SESSION['next_page'] > 0) { ?>
                                            <a href="handling/handling_next_page.php?next_page=<?php //echo $_SESSION['next_page'] - 1;         ?>"><?php //echo $_SESSION['next_page'];         ?></a>
                <?php //} ?>
                                        <a href="handling/handling_next_page.php?next_page=<?php //echo $_SESSION['next_page'];         ?>" class="active mr-3"><?php //echo $_SESSION['next_page'] + 1;         ?></a>
                                        <a href="handling/handling_next_page.php?next_page=<?php //echo $_SESSION['next_page'] + 1;         ?>"><?php //echo $_SESSION['next_page'] + 2;         ?></a>
                <?php //if ($_SESSION['next_page'] == 0) { ?>
                                            <a href="handling/handling_next_page.php?next_page=<?php //echo $_SESSION['next_page'] + 2;         ?>"><?php //echo $_SESSION['next_page'] + 3;         ?></a>
                <?php //} ?>            
                                    </ul>
                                </div>-->
            <?php } else { ?>
                <?php
                $infor_products = "product_id, product_name, product_price, product_image_1, discount";
                $query_products = mysqli_query($con, "SELECT " . $infor_product . " FROM products, product_types, coupons WHERE products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND product_name LIKE '%" . $_POST['keyword'] . "%';");
                while ($row = mysqli_fetch_array($query_products)) {
                    ?>
                    <div class="grid-container">
                        <a href="product_detail.php?product_id=<?php echo htmlentities($row['product_id']); ?>" class="product-content">
                            <div class="imageproduct text-center"><img class="radius-product" src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>"/>
                                <div class="productname text-center mt-2"><?php echo htmlentities(substr($row['product_name'], 0, 25)); ?>...</div>
                            </div>
                            <div>
                                <del class="margimobile">$<?php echo htmlentities($row['product_price']); ?></del>
                                <strong>$<?php echo htmlentities(round($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100)), 2)); ?></strong>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
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
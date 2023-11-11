<nav class="navbar__container">
    <div class="navbar__topnav navbar__topnav-main">
        <div class="topnav__item topnav__item__logo">
            <a href="index.php">
                <img class="imageradius" src="../assets/img/others/logo_meow.png" style="max-width: 130px; padding-top: 10px"
                     alt="product1">
            </a>
        </div>

        <div class="topnav__item topnav__item-fullscreen">
            <a href="index.php" class="topnav__item__button">
                HOME
            </a>
            <div id="topnav__item-product">
                <a href="" class="topnav__item__button">
                    PRODUCT
                </a>
                <div class="product__dropdown__content">
                    <?php
                    $query_type = mysqli_query($con, "SELECT product_type_id, product_type_name FROM product_types;");
                    while ($row = mysqli_fetch_array($query_type)) {
                        ?>
                        <a href="page_category.php?product_type_id=<?php echo htmlentities($row['product_type_id']); ?>"><?php echo htmlentities($row['product_type_name']); ?></a>
                    <?php } ?>
                </div>
            </div>
            <a href="" class="topnav__item__button">
                CONTACT
            </a>
        </div>
        <div class="topnav__item topnav__item-fullscreen">
            <input type="text" id="topnav__search__input" />
            <?php
            if (!isset($_SESSION['account_id'])) {
                ?>
                <a href="login.php" class="topnav__item__button">
                    LOG IN
                </a>
            <?php } else { ?> 
                <a href="account_page.php" class="topnav__item__button">
                    Hello <?php echo $_SESSION['account_name']; ?>
                </a> 
            <?php } ?>
            <div id="topnav__item__cart">
                <a class="topnav__item__button topnav__item-icon">
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <div class="cart__dropdown">
                    <?php
                    if (isset($_SESSION['account_id'])) {
                        ?>
                        <div class="cart__dropdown__list">
                            <?php
                            $total = 0;
                            $infor_cart = "products.product_id, product_name, product_price, product_image_1, discount, cart_quantity";
                            $table = "products, count_sales, product_types, coupons, carts";
                            $link = "products.product_type_id=product_types.product_type_id AND product_types.coupon_id=coupons.coupon_id AND count_sales.product_id=products.product_id AND carts.product_id=products.product_id";
                            $query_carts = mysqli_query($con, "SELECT " . $infor_cart . " FROM $table WHERE $link AND account_id=" . $_SESSION['account_id'] . ";");
                            while ($row = mysqli_fetch_array($query_carts)) {
                                $GLOBALS['total'] += (($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))) * $row['cart_quantity']);
                                ?>
                                <div class="cart__dropdown__item">
                                    <img src="../assets/img/image_products/<?php echo htmlentities($row['product_image_1']); ?>" class="cart__dropdown__image" alt="" srcset="">
                                    <div class="cart__dropdown__content">
                                        <a href="product_detail.php?product_id=<?php echo htmlentities($row['product_id']); ?>" class="cart__dropdown__content-name">
                                            <?php echo htmlentities($row['product_name']); ?>
                                        </a>
                                        <div class="cart__dropdown__content-price">
                                            <?php echo htmlentities($row['cart_quantity']); ?>
                                        </div>
                                        <div class="cart__dropdown__content-price">
                                            $<?php echo htmlentities(round(($row['product_price'] - ($row['product_price'] * ($row['discount'] / 100))) * $row['cart_quantity'], 2)); ?>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            <?php } ?>
                        </div> 
                    <?php } ?>
                    <div class="cart__dropdown__selection">
                        <a href="page_carts.php" class="cart__dropdown__button">View Cart</a>
                        <a href="checkout.php" class="cart__dropdown__button">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
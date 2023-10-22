<?php
include('../database/connect.php');
include('handling/handling_add_products.php');
if (!isset($_SESSION['account_id'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="../assets/img/others/logo_mini.png" rel="icon">
        <title>Product</title>
        <link href="../assets/others/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/others/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/admin/ruang-admin.min.css" rel="stylesheet">
        
        <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
        <script type="text/javascript">
            bkLib.onDomLoaded(function () {
                new nicEditor().panelInstance('area');
            }); // Thay thế text area có id là area1 trở thành WYSIWYG editor sử dụng nicEditor
        </script>

        <link href="../assets/others/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include('sidebar.php'); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <!-- TopBar -->
                    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                     aria-labelledby="searchDropdown">
                                    <form class="navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                                                   aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>           
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <img class="img-profile rounded-circle" src="../assets/img/avatars/<?php echo $_SESSION['avatar']; ?>" style="max-width: 60px">
                                    <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['account_name']; ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../_users/handling/handling_logout.php">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <!-- Container Fluid-->
                    <div class="container-fluid" id="container-wrapper">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Add Product</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item">Product</li>
                                <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                            </ol>
                        </div>         

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
                                </div>
                                
                                <form class="forms-sample ml-5 mb-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="">Product name</label>
                                                    <input name="product_name" type="text" class="form-control" id="" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Category</label>
                                                    <select class="form-control" name="product_type_id">
                                                        <?php
                                                        $query_all_category = mysqli_query($con, "SELECT product_type_id, product_type_name FROM product_types;");
                                                        while ($row_category = mysqli_fetch_array($query_all_category)) {
                                                            ?>
                                                            <?php if ($row_category['product_type_id'] == $row['product_type_id']) { ?>
                                                                <option value="<?php echo htmlentities($row_category['product_type_id']); ?>" selected><?php echo htmlentities($row_category['product_type_name']); ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo htmlentities($row_category['product_type_id']); ?>"><?php echo htmlentities($row_category['product_type_name']); ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>  
                                                <div class="form-group">
                                                    <label for="exampleInputPhone">Brand</label>
                                                    <input name="brand" type="text" class="form-control" id="exampleInputPhone" value="">
                                                </div>
                                            </div>    
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="birthday">Quantity</label>
                                                    <div>
                                                        <input name="product_quantity" type="text" class="form-control" value="">    
                                                    </div>                
                                                </div>  
                                                <div class="form-group">
                                                    <label for="birthday">Price</label>
                                                    <div>
                                                        <input name="product_price" type="text" class="form-control" value="">    
                                                    </div>                
                                                </div> 
                                            </div>            
                                        </div>

                                        <div class="row">
                                            <label>Pictures</label>
                                        </div>
                                        <div class="row">
                                            <?php
                                            for ($i = 1; $i <= 3; $i++) {
                                                $avatar = 'avatar_' . $i; ?>
                                                    <div class="avatar col-3">
                                                        <img src="../assets/img/image_products/empty_product.png" width="200" height="200" alt="Your picture">
                                                        <div class="template-demo">
                                                            <input type="file" class="btn btn-danger btn-icon-text" name="<?php echo $avatar; ?>" style="width: 180px;">
                                                        </div>
                                                    </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-11" style="margin-bottom: 20px">
                                                <label for="birthday">Description</label>
                                                <div>
                                                    <textarea name="product_description" id="area" style="width:70%;height:200px;"></textarea>
                                                </div>                
                                            </div> 
                                        </div>
                                    <button name="add_products" type="submit" class="btn btn-primary me-2">Add</button>
                                </form>
                                
                            </div>
                        </div>
                        <!-- Modal Logout -->
                        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to logout?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                        <a href="login.html" class="btn btn-primary">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="../assets/others/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/others/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/others/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/admin/js/ruang-admin.min.js"></script>

    <script src="../assets/others/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/others/vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>
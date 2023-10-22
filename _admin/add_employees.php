<?php
include('../database/connect.php');
include('handling/handling_add_employees.php');
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
        <title>Employee</title>
        <link href="../assets/others/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/others/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/admin/ruang-admin.min.css" rel="stylesheet">

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
                            <h1 class="h3 mb-0 text-gray-800">Add Employee</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item">Employee</li>
                                <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
                            </ol>
                        </div>         

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Employee</h6>
                                </div>
                                <form class="forms-sample ml-5 mb-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Customer name</label>
                                                    <input name="name" type="text" class="form-control" id="" placeholder="Le ngoc tuan" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input name="email" type="text" class="form-control" id="" placeholder="lengoctuan2406@gmail.com">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <input name="password" type="password" class="form-control" placeholder="748159263(Tuan)">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Re-Password</label>
                                                    <input name="re-password" type="password" class="form-control" placeholder="748159263(Tuan)">
                                                </div>
                                            </div>    
                                            <div class="avatar col-6">
                                                <img src="../assets/img/avatars/empty.png" width="200" height="200" alt="Your picture">
                                                <div class="template-demo">
                                                    <input type="hidden" name="file_old" value="<?php echo htmlentities($row['avatar']); ?>">
                                                    <input type="file" class="btn btn-danger btn-icon-text" name="avatar" style="width: 180px;">
                                                </div>
                                            </div>            
                                        </div>                                      
                                    <button name="add_employees" type="submit" class="btn btn-primary me-2">Add</button>
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
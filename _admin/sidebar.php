<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="">
            <img class="navbar-brand brand-logo" src="../assets/img/others/logo_meow.png" style="max-width: 140px; padding-top: 15px; padding-left: 25px;"
                 alt="">
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Option
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer"
           aria-expanded="true" aria-controls="collapseCustomer">
            <i class="fas fa-users"></i>
            <span>Customer</span>
        </a>
        <div id="collapseCustomer" class="collapse" aria-labelledby="headingCustomer" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Customer option</h6>
                <a class="collapse-item" href="view_customers.php">View Customer</a>
                <a class="collapse-item" href="add_customers.php">Add Customer</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee"
           aria-expanded="true" aria-controls="collapseEmployee">
            <i class="fas fa-user-friends"></i>
            <span>Employee</span>
        </a>
        <div id="collapseEmployee" class="collapse" aria-labelledby="headingEmployee" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Employee option</h6>
                <a class="collapse-item" href="view_employees.php">View Employee</a>
                <a class="collapse-item" href="add_employees.php">Add Employee</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupplier"
           aria-expanded="true" aria-controls="collapseSupplier">
            <i class="fas fa-handshake"></i>
            <span>Supplier</span>
        </a>
        <div id="collapseSupplier" class="collapse" aria-labelledby="headingSupplier" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Supplier option</h6>
                <a class="collapse-item" href="view_suppliers.php">View Supplier</a>
                <a class="collapse-item" href="add_suppliers.php">Add Supplier</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
           aria-expanded="true" aria-controls="collapseCategory">
           <!-- <i class="fas fa-user-alt"></i> -->
            <i class="fas fa-layer-group"></i>
            <span>Category</span>
        </a>
        <div id="collapseCategory" class="collapse" aria-labelledby="headingCategory" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category option</h6>
                <a class="collapse-item" href="view_categories.php">View Category</a>
                <a class="collapse-item" href="add_categories.php">Add Category</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
           aria-expanded="true" aria-controls="collapseProduct">
            <i class="fas fa-drumstick-bite"></i>
            <span>Product</span>
        </a>
        <div id="collapseProduct" class="collapse" aria-labelledby="headingProduct" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product option</h6>
                <a class="collapse-item" href="view_products.php">View Product</a>
                <a class="collapse-item" href="add_products.php">Add Product</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCoupon"
           aria-expanded="true" aria-controls="collapseCoupon">
            <i class="fas fa-dollar-sign"></i>
            <span>Coupon</span>
        </a>
        <div id="collapseCoupon" class="collapse" aria-labelledby="headingCoupon" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Coupon option</h6>
                <a class="collapse-item" href="view_coupons.php">View Coupon</a>
                <a class="collapse-item" href="add_coupons.php">Add Coupon</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder"
           aria-expanded="true" aria-controls="collapseOrder">
            <i class="fas fa-shopping-basket"></i>
            <span>Order</span>
        </a>
        <div id="collapseOrder" class="collapse" aria-labelledby="headingOrder" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Order option</h6>
                <a class="collapse-item" href="view_orders.php">View Order</a>  
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
           aria-expanded="true" aria-controls="collapseReport">
            <i class=	"	fas fa-file-alt"></i>
            <span>Report</span>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingReport" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Report option</h6>
                <a class="collapse-item" href="report_revenues.php">Revenue</a>       
                <a class="collapse-item" href="report_customers.php">Customer</a>    
                <a class="collapse-item" href="report_products.php">Product</a>   
            </div>
        </div>
    </li>
</ul>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- sidebar menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- DASHBOARD -->
            <li class="header">MAIN NAVIGATION</li>
            <?php $uri = new \CodeIgniter\HTTP\URI(current_url()); ?>
            
            <li class="<?= ($uri->getSegment(count($uri->getSegments())) == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/dashboard') ?>">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <?php
            if($data[0]['type'] === "ADMIN") {
            ?>

            <!-- USERS -->
            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'users') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/users') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage Users
                        </a>
                    </li>
                </ul>
            </li>

            <!-- PINCODES -->
            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'pincodes') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-map-marker"></i>
                    <span>Pincodes</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/pincodes') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage Pincodes
                        </a>
                    </li>
                </ul>
            </li>
            
            

            <!-- ORDERS & RELATED TABLES -->
            <li class="treeview
                <?php
                    $activeMenus = [
                        'orders','order-details','delivery-addresses',
                        'payments','insurance-documents','order-status-history','list-pending'
                    ];
                    echo in_array($uri->getSegment(count($uri->getSegments())), $activeMenus)
                         ? 'active menu-open'
                         : '';
                ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-shopping-basket"></i>
                    <span>Orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/orders') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage Orders
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/order-details') ?>">
                            <i class="fa fa-angle-right"></i>
                            Order Details
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/delivery-addresses') ?>">
                            <i class="fa fa-angle-right"></i>
                            Delivery Addresses
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/payments') ?>">
                            <i class="fa fa-angle-right"></i>
                            Payments
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/insurance-documents') ?>">
                            <i class="fa fa-angle-right"></i>
                            Insurance Documents
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/order-status-history') ?>">
                            <i class="fa fa-angle-right"></i>
                            Order Status History
                        </a>
                    </li>
                    <!-- New menu item for pending-review orders -->
                    <li>
                        <a href="<?= base_url('admin/orders?status=pending') ?>">
                            <i class="fa fa-angle-right"></i>
                            Orders Awaiting Review
                        </a>
                    </li>
                </ul>
            </li>

            <!-- OPTIONALLY: ADMIN SETTINGS, USER SESSIONS, ETC. -->
            <li class="header">SYSTEM</li>
            <!--<li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'admin-settings') ? 'active menu-open' : '' ?>">-->
            <!--    <a href="javascript:void(0)">-->
            <!--        <i class="fa fa-user-secret"></i>-->
            <!--        <span>Admin Settings</span>-->
            <!--        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
            <!--        <li>-->
            <!--            <a href="<?= base_url('admin/admin-users') ?>">-->
            <!--                <i class="fa fa-angle-right"></i>-->
            <!--                Manage Admin Users-->
            <!--            </a>-->
            <!--        </li>-->
            <!--    </ul>-->
            <!--</li>-->

            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'user-sessions') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-clock-o"></i>
                    <span>Sessions</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/user-sessions') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage User Sessions
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- DISTRIBUTORS -->
            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'distributors') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i>
                    <span>Distributors</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/distributors') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage Distributors
                        </a>
                    </li>
                </ul>
            </li>

            <!-- WEBSITE CONTENT -->
            <li class="header">WEBSITE MANAGEMENT</li>

            <li class="treeview <?= in_array($uri->getSegment(count($uri->getSegments())), ['companies', 'partners', 'board-members']) ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-globe"></i>
                    <span>Website Content</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/companies') ?>">
                            <i class="fa fa-angle-right"></i>
                            Companies
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/partners') ?>">
                            <i class="fa fa-angle-right"></i>
                            Partners
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/board-members') ?>">
                            <i class="fa fa-angle-right"></i>
                            Board Members
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/news-items') ?>">
                            <i class="fa fa-angle-right"></i>
                            News Items
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'contact-submissions') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-envelope-o"></i>
                    <span>Contact Form</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/contact-submissions') ?>">
                            <i class="fa fa-angle-right"></i>
                            View Submissions
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'site-settings') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-cog"></i>
                    <span>Site Settings</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/site-settings') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage Settings
                        </a>
                    </li>
                </ul>
            </li>


            <?php
            } else if($data[0]['type'] === "DISTRIBUTOR"){
            ?>
            <!-- COUPONS -->
            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'customer-coupons') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-ticket"></i>
                    <span>Coupons</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/customer-coupons') ?>">
                            <i class="fa fa-angle-right"></i>
                            Manage Coupons
                        </a>
                    </li>
                </ul>
            </li>
            <!-- COUPON BULK UPLOAD -->
            <li class="treeview <?= ($uri->getSegment(count($uri->getSegments())) == 'coupons-bulk-upload') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-upload"></i>
                    <span>Coupon Bulk Upload</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('admin/coupons/bulk-upload') ?>">
                            <i class="fa fa-angle-right"></i>
                            Upload Coupons
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/coupons/bulk-template') ?>">
                            <i class="fa fa-angle-right"></i>
                            Download Template
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>
    <!-- /.sidebar -->
</aside>

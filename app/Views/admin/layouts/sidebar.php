<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="padding: 15px; text-align: center; border-bottom: 1px solid #444;">
            <div class="pull-left image">
                <i class="fa fa-user-circle" style="font-size: 45px; color: #fff;"></i>
            </div>
            <div class="pull-left info">
                <p style="color: #fff; margin-bottom: 5px;">
                    <?= isset($data[0]['name']) ? esc($data[0]['name']) : 'Admin' ?>
                </p>
                <span style="font-size: 11px; color: #aaa;">
                    <?= isset($data[0]['type']) ? ucfirst(strtolower($data[0]['type'])) : 'Administrator' ?>
                </span>
            </div>
        </div>

        <!-- sidebar menu: -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php
            $uri = service('uri');
            $segment2 = $uri->getSegment(2);
            ?>

            <!-- MAIN NAVIGATION -->
            <li class="header">MAIN NAVIGATION</li>

            <li class="<?= ($segment2 == 'dashboard' || $segment2 == '') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/dashboard') ?>">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- WEBSITE MANAGEMENT -->
            <li class="header">WEBSITE MANAGEMENT</li>

            <!-- Companies -->
            <li class="<?= ($segment2 == 'companies') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/companies') ?>">
                    <i class="fa fa-building"></i>
                    <span>Companies</span>
                </a>
            </li>

            <!-- Partners -->
            <li class="<?= ($segment2 == 'partners') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/partners') ?>">
                    <i class="fa fa-handshake-o"></i>
                    <span>Partners</span>
                </a>
            </li>

            <!-- Board Members -->
            <li class="<?= ($segment2 == 'board-members') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/board-members') ?>">
                    <i class="fa fa-users"></i>
                    <span>Board Members</span>
                </a>
            </li>

            <!-- Timeline -->
            <li class="<?= ($segment2 == 'timeline') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/timeline') ?>">
                    <i class="fa fa-history"></i>
                    <span>Timeline</span>
                </a>
            </li>

            <!-- News Items -->
            <li class="<?= ($segment2 == 'news') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/news') ?>">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News & Updates</span>
                </a>
            </li>

            <!-- Contact Submissions -->
            <li class="<?= ($segment2 == 'contacts') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/contacts') ?>">
                    <i class="fa fa-envelope"></i>
                    <span>Contact Submissions</span>
                </a>
            </li>

            <!-- SETTINGS -->
            <li class="header">SETTINGS</li>

            <!-- Site Settings -->
            <li class="<?= ($segment2 == 'settings') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/settings') ?>">
                    <i class="fa fa-cogs"></i>
                    <span>Site Settings</span>
                </a>
            </li>

            <!-- Site Images -->
            <li class="<?= ($segment2 == 'images') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/images') ?>">
                    <i class="fa fa-picture-o"></i>
                    <span>Site Images</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="<?= ($segment2 == 'profile') ? 'active' : '' ?>">
                <a href="<?= base_url('admin/profile') ?>">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <a href="<?= base_url('admin/logout') ?>" onclick="return confirm('Are you sure you want to logout?')">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

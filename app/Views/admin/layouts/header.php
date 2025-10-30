<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RK Group - Admin Panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?=base_url('/assets/img/RKGroup logo.svg')?>">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome from CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- AdminLTE 2 CSS from CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/skins/_all-skins.min.css">

    <!-- jQuery 3 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/js/adminlte.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
    /* Apply Poppins font to entire admin panel */
    body, h1, h2, h3, h4, h5, h6, p, a, span, div, button, input, select, textarea, label, li, td, th {
        font-family: 'Poppins', sans-serif !important;
    }

    .cbNewBx .gc-filtering-modal {
        display: none;
    }

    /* Logo styling */
    .logo img {
        max-height: 50px;
        width: auto;
        /* Make logo white */
        filter: brightness(0) invert(1);
    }

    /* Header colors */
    .main-header .logo {
        background-color: #2C3E50 !important;
    }
    .main-header .navbar {
        background-color: #2C3E50 !important;
    }

    /* Fix sidebar toggle button visibility */
    .sidebar-toggle {
        display: inline-block !important;
        color: #fff !important;
        padding: 15px !important;
        cursor: pointer !important;
    }
    .sidebar-toggle:before {
        content: "\f0c9" !important;
        font-family: 'FontAwesome' !important;
    }
    </style>

</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper boxed-wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?=base_url('admin/dashboard')?>" class="logo blue-bg">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><img src="<?=base_url('/assets/img/RKGroup logo.svg')?>"
                        width="50px;" alt="RK Group"></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><img src="<?=base_url('/assets/img/RKGroup logo.svg')?>"
                        width="140px;" alt="RK Group"></span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar blue-bg navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account  -->
                        <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle"
                                data-toggle="dropdown"> <span class="hidden-xs"><?=$data[0]['userid']?></span> </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <div class="pull-left user-img"></div>
                                    <p class="text-left"><?=$data[0]['userid']?> <small>Admin</small> </p>
                                </li>
                                <li><a href="<?=base_url('admin/profile')?>"><i class="icon-lock"></i> Change
                                        Password</a></li>
                                <li><a href="<?=base_url('admin/logout');?>"><i class="fa fa-power-off"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

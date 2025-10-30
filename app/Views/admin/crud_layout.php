<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<style>
/* Modern CRUD Page Styling */
.content-wrapper {
    background: #f4f6f9;
    min-height: calc(100vh - 50px);
}

.page-header-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px 0;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.page-header-modern .page-title {
    color: #ffffff;
    font-size: 28px;
    font-weight: 600;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header-modern .breadcrumb {
    background: transparent;
    margin: 8px 0 0 0;
    padding: 0;
}

.page-header-modern .breadcrumb li {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
}

.page-header-modern .breadcrumb li a {
    color: #ffffff;
    text-decoration: none;
}

.page-header-modern .breadcrumb li a:hover {
    text-decoration: underline;
}

.modern-card {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    border: none;
    margin-bottom: 30px;
    overflow: hidden;
}

.modern-card-body {
    padding: 30px;
}

/* GroceryCRUD Table Beautification */
.cbNewBx table {
    border-radius: 10px;
    overflow: hidden;
}

.cbNewBx .table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    border: none;
    padding: 15px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.5px;
}

.cbNewBx .table tbody tr {
    transition: all 0.3s ease;
}

.cbNewBx .table tbody tr:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.cbNewBx .table tbody td {
    padding: 15px;
    vertical-align: middle;
    border-color: #e9ecef;
}

/* Button Styling */
.cbNewBx .btn, .gc-button {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.cbNewBx .btn-success, .gc-button.gc-button-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.cbNewBx .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.cbNewBx .btn-primary {
    background: #667eea;
    border: none;
}

.cbNewBx .btn-danger {
    background: #e74c3c;
    border: none;
}

.cbNewBx .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Search Box */
.cbNewBx .gc-search-box {
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.cbNewBx .gc-search-box:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Pagination */
.cbNewBx .pagination {
    margin-top: 20px;
}

.cbNewBx .pagination li a {
    border-radius: 8px;
    margin: 0 3px;
    border: none;
    background: #f8f9fa;
    color: #667eea;
    font-weight: 500;
}

.cbNewBx .pagination li.active a {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
}

/* Loading Spinner */
.cbNewBx .gc-loading {
    border-radius: 50%;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-modern {
        padding: 20px 0;
    }

    .page-header-modern .page-title {
        font-size: 22px;
    }

    .modern-card-body {
        padding: 20px 15px;
    }
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Modern Page Header -->
    <div class="page-header-modern">
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-database"></i> Manage <?= esc($breadcrumbs) ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><i class="fa fa-angle-right"></i></li>
                <li class="active"><?= esc($breadcrumbs) ?></li>
            </ol>
        </div>
    </div>

    <!-- Main content -->
    <div class="content" style="padding: 30px 15px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="modern-card">
                        <div class="modern-card-body">
                            <div class="cbNewBx">
                                <!-- GroceryCRUD layout -->
                                <?php echo $output; ?>
                                <!-- // GroceryCRUD layout -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>

<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

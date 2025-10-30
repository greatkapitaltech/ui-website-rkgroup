<?php
// Load ALL GroceryCRUD CSS files
foreach($css_files as $file):
?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<!-- Re-load Font Awesome AFTER GroceryCRUD to ensure it takes precedence -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/* CRITICAL: Ensure ALL icons use Font Awesome */
i, .fa, [class*="fa-"], [class*="icon-"], [class*="glyphicon-"] {
	font-family: 'FontAwesome' !important;
}

/* Override any conflicting font-family declarations */
.main-sidebar i,
.navbar i,
.content-wrapper i,
.sidebar-menu i {
	font-family: 'FontAwesome' !important;
	font-style: normal !important;
	font-weight: normal !important;
	line-height: 1 !important;
	-webkit-font-smoothing: antialiased !important;
	-moz-osx-font-smoothing: grayscale !important;
	display: inline-block !important;
}

/* Specific fix for Font Awesome 4.7 icons that might not render */
.fa-user-circle:before {
	content: "\f2bd" !important;
	font-family: 'FontAwesome' !important;
}

.fa-handshake-o:before {
	content: "\f2b5" !important;
	font-family: 'FontAwesome' !important;
}

/* Ensure sidebar icons are visible */
.sidebar-menu li > a > i {
	font-family: 'FontAwesome' !important;
	display: inline-block !important;
	width: auto !important;
	text-align: center !important;
	margin-right: 10px !important;
}

/* Ensure user panel icon is visible */
.user-panel .fa {
	font-family: 'FontAwesome' !important;
	display: inline-block !important;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= esc($breadcrumbs) ?>
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= esc($breadcrumbs) ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php echo $output; ?>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

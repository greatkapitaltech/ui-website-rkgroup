<?php foreach($css_files as $file): ?>
	<?php
	// Skip loading icon libraries from GroceryCRUD
	if (strpos($file, 'fontawesome') === false &&
	    strpos($file, 'glyphicons') === false &&
	    strpos($file, 'icons') === false):
	?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endif; ?>
<?php endforeach; ?>

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

<?php
// Load ALL GroceryCRUD CSS files without filtering
// We'll override conflicting styles with scoped CSS instead
foreach($css_files as $file):
?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<style>
/* SCOPED: Only affect GroceryCRUD content inside .content-wrapper */
/* This way sidebar and header icons are NOT affected */

/* Override GroceryCRUD icons to use AdminLTE's Font Awesome 4.x */
.content-wrapper .gcrud-icon {
	font-family: 'FontAwesome' !important;
}

/* Action buttons - only in content wrapper */
.content-wrapper .gcrud-icon.gcrud-edit-icon:before { content: "\f044" !important; } /* fa-edit */
.content-wrapper .gcrud-icon.gcrud-delete-icon:before { content: "\f014" !important; } /* fa-trash */
.content-wrapper .gcrud-icon.gcrud-view-icon:before { content: "\f06e" !important; } /* fa-eye */
.content-wrapper .gcrud-icon.gcrud-clone-icon:before { content: "\f0c5" !important; } /* fa-copy */
.content-wrapper .gcrud-icon.gcrud-add-icon:before { content: "\f067" !important; } /* fa-plus */
.content-wrapper .gcrud-icon.gcrud-save-icon:before { content: "\f00c" !important; } /* fa-check */
.content-wrapper .gcrud-icon.gcrud-cancel-icon:before { content: "\f00d" !important; } /* fa-times */
.content-wrapper .gcrud-icon.gcrud-back-icon:before { content: "\f060" !important; } /* fa-arrow-left */
.content-wrapper .gcrud-icon.gcrud-search-icon:before { content: "\f002" !important; } /* fa-search */
.content-wrapper .gcrud-icon.gcrud-filter-icon:before { content: "\f0b0" !important; } /* fa-filter */
.content-wrapper .gcrud-icon.gcrud-export-icon:before { content: "\f019" !important; } /* fa-download */
.content-wrapper .gcrud-icon.gcrud-print-icon:before { content: "\f02f" !important; } /* fa-print */
.content-wrapper .gcrud-icon.gcrud-upload-icon:before { content: "\f093" !important; } /* fa-upload */

/* Ensure Font Awesome is used for all GroceryCRUD icons */
.content-wrapper .gcrud-icon:not(.fa):before {
	font-family: 'FontAwesome' !important;
}

/* DO NOT hide any icons globally - let Font Awesome work naturally */
</style>

<!-- No JavaScript manipulation needed - scoped CSS handles it -->

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

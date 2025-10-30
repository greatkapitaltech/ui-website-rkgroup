<?php foreach($css_files as $file): ?>
	<?php
	// Skip loading icon libraries from GroceryCRUD - use AdminLTE's Font Awesome instead
	$skipFile = false;
	$skipPatterns = ['fontawesome', 'glyphicons', 'icons', 'material-icons', 'icomoon', 'iconic'];
	foreach ($skipPatterns as $pattern) {
		if (stripos($file, $pattern) !== false) {
			$skipFile = true;
			break;
		}
	}
	if (!$skipFile):
	?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endif; ?>
<?php endforeach; ?>

<style>
/* Override GroceryCRUD icons to use AdminLTE's Font Awesome 4.x */
/* Map common GroceryCRUD icon classes to Font Awesome */
.gcrud-icon {
	font-family: 'FontAwesome' !important;
}

/* Action buttons */
.gcrud-icon.gcrud-edit-icon:before { content: "\f044" !important; } /* fa-edit */
.gcrud-icon.gcrud-delete-icon:before { content: "\f014" !important; } /* fa-trash */
.gcrud-icon.gcrud-view-icon:before { content: "\f06e" !important; } /* fa-eye */
.gcrud-icon.gcrud-clone-icon:before { content: "\f0c5" !important; } /* fa-copy */

/* Add/Create buttons */
.gcrud-icon.gcrud-add-icon:before { content: "\f067" !important; } /* fa-plus */
.gcrud-icon.gcrud-create-icon:before { content: "\f067" !important; } /* fa-plus */

/* Save/Update buttons */
.gcrud-icon.gcrud-save-icon:before { content: "\f00c" !important; } /* fa-check */
.gcrud-icon.gcrud-update-icon:before { content: "\f00c" !important; } /* fa-check */

/* Cancel/Back buttons */
.gcrud-icon.gcrud-cancel-icon:before { content: "\f00d" !important; } /* fa-times */
.gcrud-icon.gcrud-back-icon:before { content: "\f060" !important; } /* fa-arrow-left */

/* Search/Filter */
.gcrud-icon.gcrud-search-icon:before { content: "\f002" !important; } /* fa-search */
.gcrud-icon.gcrud-filter-icon:before { content: "\f0b0" !important; } /* fa-filter */

/* Export */
.gcrud-icon.gcrud-export-icon:before { content: "\f019" !important; } /* fa-download */
.gcrud-icon.gcrud-print-icon:before { content: "\f02f" !important; } /* fa-print */

/* Pagination */
.gcrud-icon.gcrud-previous-icon:before { content: "\f104" !important; } /* fa-angle-left */
.gcrud-icon.gcrud-next-icon:before { content: "\f105" !important; } /* fa-angle-right */
.gcrud-icon.gcrud-first-icon:before { content: "\f100" !important; } /* fa-angle-double-left */
.gcrud-icon.gcrud-last-icon:before { content: "\f101" !important; } /* fa-angle-double-right */

/* Upload/File */
.gcrud-icon.gcrud-upload-icon:before { content: "\f093" !important; } /* fa-upload */
.gcrud-icon.gcrud-file-icon:before { content: "\f15b" !important; } /* fa-file */

/* Loading/Refresh */
.gcrud-icon.gcrud-loading-icon:before { content: "\f021" !important; } /* fa-refresh */
.gcrud-icon.gcrud-refresh-icon:before { content: "\f021" !important; } /* fa-refresh */

/* Sort */
.gcrud-icon.gcrud-sort-asc-icon:before { content: "\f0de" !important; } /* fa-sort-asc */
.gcrud-icon.gcrud-sort-desc-icon:before { content: "\f0dd" !important; } /* fa-sort-desc */
.gcrud-icon.gcrud-sort-icon:before { content: "\f0dc" !important; } /* fa-sort */

/* Settings/Config */
.gcrud-icon.gcrud-settings-icon:before { content: "\f013" !important; } /* fa-cog */

/* Calendar/Date */
.gcrud-icon.gcrud-calendar-icon:before { content: "\f073" !important; } /* fa-calendar */

/* Close/Remove */
.gcrud-icon.gcrud-close-icon:before { content: "\f00d" !important; } /* fa-times */
.gcrud-icon.gcrud-remove-icon:before { content: "\f00d" !important; } /* fa-times */

/* Success/Error/Info/Warning icons */
.gcrud-icon.gcrud-success-icon:before { content: "\f00c" !important; } /* fa-check */
.gcrud-icon.gcrud-error-icon:before { content: "\f071" !important; } /* fa-exclamation-triangle */
.gcrud-icon.gcrud-info-icon:before { content: "\f05a" !important; } /* fa-info-circle */
.gcrud-icon.gcrud-warning-icon:before { content: "\f06a" !important; } /* fa-exclamation-circle */

/* Hide any remaining icon fonts that might conflict */
[class*="glyphicon-"]:before,
[class*="material-icons"]:before,
[class*="ionic-"]:before {
	display: none !important;
}

/* Ensure GroceryCRUD uses Font Awesome for all icons */
.gcrud-icon:not(.fa):before {
	font-family: 'FontAwesome' !important;
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

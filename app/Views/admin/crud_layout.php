<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Manage <?=$breadcrumbs?></h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> manage <?=strtolower($breadcrumbs)?></li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <div class="cbNewBx">
                        <!-- grocery crud layout -->
                        <?php echo $output; ?>
                        <!-- // grocery crud layout -->
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
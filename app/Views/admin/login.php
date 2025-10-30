<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>RK Group - Admin Login</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- v4.0.0-alpha.6 -->
<link rel="stylesheet" href="<?=base_url('assets/admin_assets/dist/bootstrap/css/bootstrap.min.css');?>">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="<?=base_url('assets/admin_assets/dist/css/style.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/admin_assets/dist/css/font-awesome/css/font-awesome.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/admin_assets/dist/css/et-line-font/et-line-font.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/admin_assets/dist/css/themify-icons/themify-icons.css')?>">

<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
/* Apply Poppins font to login page */
body, h1, h2, h3, h4, h5, h6, p, a, span, div, button, input, select, textarea, label {
    font-family: 'Poppins', sans-serif !important;
}
</style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-box-body">
    <h3 class="login-box-msg">Admin Sign In</h3>
    <form action="<?=base_url('admin/login-submit')?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="UserId" name="userid" required>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
      </div>

      <div>
        <!-- /.col -->
        <div class="col-xs-4 m-t-1">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      <!-- /.col --> 
      </div>
    </form>
  
  </div>
  <!-- /.login-box-body --> 
</div>
<!-- /.login-box --> 

<!-- jQuery 3 --> 
<script src="<?=base_url('assets/admin_assets/dist/js/jquery.min.js')?>"></script> 

<!-- v4.0.0-alpha.6 --> 
<script src="<?=base_url('assets/admin_assets/dist/bootstrap/js/bootstrap.min.js')?>"></script> 


</body>
</html>
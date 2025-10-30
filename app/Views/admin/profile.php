
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Profile</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Profile</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
          <div class="col-12">
              <div class="card">
                    <div class="card-header bg-primary text-white">Change Password</div>
                    <div class="card-body">
                        <form action="profile-submit" method="POST">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" placeholder="Old Password" class="form-control" name="old_password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" placeholder="New Password" class="form-control" name="new_password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" placeholder="Confirm Password" class="form-control" name="confirm_password">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
              </div>
          </div>
      </div>
    </div>
    <!-- /.content --> 
  </div>

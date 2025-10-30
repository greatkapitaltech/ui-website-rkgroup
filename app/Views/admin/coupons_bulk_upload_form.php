<div class="content-wrapper">
  <div class="content-header sty-one">
    <h1>Bulk Upload Coupons</h1>
    <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li><i class="fa fa-angle-right"></i> Coupons</li>
      <li><i class="fa fa-angle-right"></i> Bulk Upload</li>
    </ol>
  </div>

  <div class="content">
    <?php if (!empty($flashError)): ?>
      <div class="alert alert-danger"><?= esc($flashError) ?></div>
    <?php endif; ?>
    <?php if (!empty($flashSuccess)): ?>
      <div class="alert alert-success"><?= esc($flashSuccess) ?></div>
    <?php endif; ?>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <p class="m-b-2">
              Download the CSV template, fill in rows, and upload. <br>
              <strong>Note:</strong> <code>coupon_code</code> is auto-generated and <code>account_id</code> is bound to your account id.
            </p>

            <a href="<?= esc($templateUrl) ?>">
              <i class="fa fa-download"></i> Download Template
            </a>

            <hr>

            <form action="<?= base_url('admin/coupons/bulk-upload') ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>CSV File</label>
                <input type="file" name="csv_file" accept=".csv" class="form-control" required>
                <small class="text-muted">
                   Required columns: <code>customer_name, customer_pincode, customer_number</code>.<br>
                      Optional: <code>status</code> (active|inactive|expired|used_up).<br>
                      The system will set <code>valid_from</code> = today, <code>valid_to</code> = +1 year, 
                      <code>usage_limit_per_coupon</code> = 1, <code>usage_limit_per_customer</code> = 1.
                      If those headers exist in the CSV, they will be ignored.
                </small>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-upload"></i> Upload
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>

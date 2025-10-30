<div class="content-wrapper">
  <div class="content-header sty-one">
    <h1>Bulk Upload Coupons</h1>
    <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li><i class="fa fa-angle-right"></i> Coupons</li>
      <li><i class="fa fa-angle-right"></i> Upload Summary</li>
    </ol>
  </div>

  <div class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">

            <p><strong>Inserted:</strong> <?= (int)($summary['inserted'] ?? 0) ?></p>
            <p><strong>Failed:</strong> <?= (int)($summary['failed'] ?? 0) ?></p>

            <?php if (!empty($summary['errors'])): ?>
              <div class="alert alert-warning">
                <strong>Row Errors</strong>
                <ul style="margin-top:8px">
                  <?php foreach ($summary['errors'] as $msg): ?>
                    <li><?= esc($msg) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <a href="<?= base_url('admin/coupons/bulk-upload') ?>" class="btn btn-default">
              <i class="fa fa-reply"></i> Back
            </a>
            <a href="<?= base_url('admin/customer-coupons') ?>" class="btn btn-primary">
              <i class="fa fa-list"></i> Go to Coupons
            </a>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

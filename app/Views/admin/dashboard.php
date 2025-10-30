<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= model('CompaniesModel')->countAll() ?></h3>
                        <p>Companies</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <a href="<?= base_url('admin/companies') ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= model('PartnersModel')->countAll() ?></h3>
                        <p>Partners</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-handshake-o"></i>
                    </div>
                    <a href="<?= base_url('admin/partners') ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= model('BoardMembersModel')->countAll() ?></h3>
                        <p>Board Members</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?= base_url('admin/board-members') ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= model('ContactSubmissionsModel')->where('status', 'new')->countAllResults() ?></h3>
                        <p>New Contacts</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <a href="<?= base_url('admin/contacts') ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="box-body">
                        <a href="<?= base_url('admin/companies') ?>" class="btn btn-app">
                            <i class="fa fa-building"></i> Companies
                        </a>
                        <a href="<?= base_url('admin/partners') ?>" class="btn btn-app">
                            <i class="fa fa-handshake-o"></i> Partners
                        </a>
                        <a href="<?= base_url('admin/board-members') ?>" class="btn btn-app">
                            <i class="fa fa-users"></i> Board Members
                        </a>
                        <a href="<?= base_url('admin/timeline') ?>" class="btn btn-app">
                            <i class="fa fa-history"></i> Timeline
                        </a>
                        <a href="<?= base_url('admin/news') ?>" class="btn btn-app">
                            <i class="fa fa-newspaper-o"></i> News
                        </a>
                        <a href="<?= base_url('admin/contacts') ?>" class="btn btn-app">
                            <i class="fa fa-envelope"></i> Contacts
                        </a>
                        <a href="<?= base_url('admin/settings') ?>" class="btn btn-app">
                            <i class="fa fa-cogs"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Contact Submissions -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-envelope-open"></i> Recent Contact Submissions</h3>
                        <div class="box-tools pull-right">
                            <a href="<?= base_url('admin/contacts') ?>" class="btn btn-box-tool">
                                <i class="fa fa-arrow-circle-right"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recent = model('ContactSubmissionsModel')
                                        ->orderBy('created_at', 'DESC')
                                        ->limit(5)
                                        ->find();
                                    if (!empty($recent)):
                                        foreach ($recent as $contact):
                                    ?>
                                    <tr>
                                        <td><strong><?= esc($contact['name']) ?></strong></td>
                                        <td><?= esc($contact['email']) ?></td>
                                        <td><?= esc($contact['subject']) ?></td>
                                        <td><?= date('M d, Y', strtotime($contact['created_at'])) ?></td>
                                        <td>
                                            <span class="label label-<?= $contact['status'] == 'new' ? 'danger' : 'success' ?>">
                                                <?= strtoupper(esc($contact['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    else:
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center" style="padding: 30px;">
                                            <i class="fa fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                                            <br><span class="text-muted">No contact submissions yet</span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

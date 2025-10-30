<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>RK Group Admin Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Companies</span>
                        <span class="info-box-number"><?= model('CompaniesModel')->countAll() ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-handshake-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Partners</span>
                        <span class="info-box-number"><?= model('PartnersModel')->countAll() ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Board Members</span>
                        <span class="info-box-number"><?= model('BoardMembersModel')->countAll() ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Contacts</span>
                        <span class="info-box-number"><?= model('ContactSubmissionsModel')->where('status', 'new')->countAllResults() ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quick Actions</h3>
                    </div>
                    <div class="box-body">
                        <a href="<?= base_url('admin/companies') ?>" class="btn btn-app">
                            <i class="fa fa-building"></i> Manage Companies
                        </a>
                        <a href="<?= base_url('admin/partners') ?>" class="btn btn-app">
                            <i class="fa fa-handshake-o"></i> Manage Partners
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
                            <span class="badge bg-red"><?= model('ContactSubmissionsModel')->where('status', 'new')->countAllResults() ?></span>
                            <i class="fa fa-envelope"></i> Contacts
                        </a>
                        <a href="<?= base_url('admin/settings') ?>" class="btn btn-app">
                            <i fa fa-cogs"></i> Settings
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
                        <h3 class="box-title">Recent Contact Submissions</h3>
                        <div class="box-tools pull-right">
                            <a href="<?= base_url('admin/contacts') ?>" class="btn btn-box-tool">View All</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
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
                                        <td><?= esc($contact['name']) ?></td>
                                        <td><?= esc($contact['email']) ?></td>
                                        <td><?= esc($contact['subject']) ?></td>
                                        <td><?= date('M d, Y', strtotime($contact['created_at'])) ?></td>
                                        <td>
                                            <span class="label label-<?= $contact['status'] == 'new' ? 'danger' : 'success' ?>">
                                                <?= esc($contact['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    else:
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No contact submissions yet</td>
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
<!-- /.content-wrapper -->

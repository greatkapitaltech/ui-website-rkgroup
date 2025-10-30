<style>
.dashboard-modern {
    background: #f4f6f9;
    min-height: calc(100vh - 50px);
}

.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 0;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.dashboard-header h1 {
    color: #ffffff;
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dashboard-header small {
    color: rgba(255,255,255,0.9);
    font-size: 16px;
    font-weight: 400;
}

.stat-card {
    background: #ffffff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
    margin-bottom: 25px;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 65px;
    height: 65px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #ffffff;
    margin-bottom: 15px;
}

.stat-icon.bg-aqua {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-icon.bg-green {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.stat-icon.bg-yellow {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon.bg-red {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.stat-number {
    font-size: 36px;
    font-weight: 700;
    color: #2C3E50;
    margin: 10px 0;
}

.stat-label {
    font-size: 14px;
    color: #7f8c8d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-box {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    padding: 25px;
    margin-bottom: 25px;
}

.modern-box-title {
    font-size: 20px;
    font-weight: 600;
    color: #2C3E50;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.quick-action-btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    margin: 5px;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    color: #ffffff;
    text-decoration: none;
}

.table-modern {
    margin-top: 15px;
}

.table-modern thead th {
    background: #f8f9fa;
    color: #667eea;
    border: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    padding: 12px;
}

.table-modern tbody td {
    padding: 12px;
    vertical-align: middle;
    border-color: #f0f0f0;
}

.table-modern tbody tr:hover {
    background: #f8f9fa;
}

.badge-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-new {
    background: #e74c3c;
    color: #ffffff;
}

.badge-read {
    background: #11998e;
    color: #ffffff;
}
</style>

<!-- Content Wrapper -->
<div class="content-wrapper dashboard-modern">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <h1>
                <i class="fa fa-dashboard"></i> Dashboard
                <small style="display: block; margin-top: 8px;">Welcome to RK Group Admin Panel</small>
            </h1>
        </div>
    </div>

    <!-- Main content -->
    <section class="content" style="padding: 0 15px 30px;">
        <div class="container-fluid">
            <!-- Stat Cards -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-aqua">
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="stat-number"><?= model('CompaniesModel')->countAll() ?></div>
                        <div class="stat-label">Companies</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-green">
                            <i class="fa fa-handshake-o"></i>
                        </div>
                        <div class="stat-number"><?= model('PartnersModel')->countAll() ?></div>
                        <div class="stat-label">Partners</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-yellow">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-number"><?= model('BoardMembersModel')->countAll() ?></div>
                        <div class="stat-label">Board Members</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-red">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="stat-number"><?= model('ContactSubmissionsModel')->where('status', 'new')->countAllResults() ?></div>
                        <div class="stat-label">New Contacts</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="modern-box">
                        <h3 class="modern-box-title">
                            <i class="fa fa-bolt"></i> Quick Actions
                        </h3>
                        <div>
                            <a href="<?= base_url('admin/companies') ?>" class="quick-action-btn">
                                <i class="fa fa-building"></i> Companies
                            </a>
                            <a href="<?= base_url('admin/partners') ?>" class="quick-action-btn">
                                <i class="fa fa-handshake-o"></i> Partners
                            </a>
                            <a href="<?= base_url('admin/board-members') ?>" class="quick-action-btn">
                                <i class="fa fa-users"></i> Board Members
                            </a>
                            <a href="<?= base_url('admin/timeline') ?>" class="quick-action-btn">
                                <i class="fa fa-history"></i> Timeline
                            </a>
                            <a href="<?= base_url('admin/news') ?>" class="quick-action-btn">
                                <i class="fa fa-newspaper-o"></i> News
                            </a>
                            <a href="<?= base_url('admin/contacts') ?>" class="quick-action-btn">
                                <i class="fa fa-envelope"></i> Contacts
                            </a>
                            <a href="<?= base_url('admin/settings') ?>" class="quick-action-btn">
                                <i class="fa fa-cogs"></i> Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Contact Submissions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="modern-box">
                        <h3 class="modern-box-title">
                            <i class="fa fa-envelope-open"></i> Recent Contact Submissions
                            <a href="<?= base_url('admin/contacts') ?>" class="pull-right" style="font-size: 14px; font-weight: 500; color: #667eea;">
                                View All <i class="fa fa-arrow-right"></i>
                            </a>
                        </h3>
                        <div class="table-responsive">
                            <table class="table table-modern">
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
                                            <span class="badge-status badge-<?= $contact['status'] == 'new' ? 'new' : 'read' ?>">
                                                <?= strtoupper(esc($contact['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    else:
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center" style="padding: 30px; color: #95a5a6;">
                                            <i class="fa fa-inbox" style="font-size: 48px; margin-bottom: 10px;"></i>
                                            <br>No contact submissions yet
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
</div>

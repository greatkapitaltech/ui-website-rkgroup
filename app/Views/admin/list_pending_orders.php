<link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Manage Pending Orders</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> manage pending-orders</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <div class="cbNewBx">
                        <table id="ordersTable" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $order): ?>
                                  <tr>
                                    <td><?= esc($order['order_id']) ?></td>
                                    <td><?= esc($order['user_id']) ?></td>
                                    <td><?= esc($order['total_amount']) ?></td>
                                    <td>
                                      <a class="btn btn-primary btn-sm" 
                                         href="<?= base_url('admin/editOrderDetails/'.$order['order_id']) ?>">
                                        Add Medicines / Apply Discount
                                      </a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <tr><td colspan="4">No orders found.</td></tr>
                              <?php endif; ?>
                            </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <!-- /.content --> 
  </div>
<script src="https://cdn.datatables.net/2.2.0/js/dataTables.min.js"></script>
<script>
  $(document).ready(function(){
    $('#ordersTable').DataTable({columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }]});
  });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header sty-one">
    <h1>Manage Order Details</h1>
    <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li><i class="fa fa-angle-right"></i> manage order-details</li>
    </ol>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="cbNewBx">

              <!-- Begin the form -->
              <form
                action="<?= base_url('admin/updateOrderDetails') ?>"
                method="post"
                enctype="multipart/form-data"
                class="mb-5"
              >
                <!-- Hidden field to identify the order -->
                <input
                  type="hidden"
                  name="order_id"
                  value="<?= esc($order['order_id']) ?>"
                />

                <hr />
                <h4>Medicine Line Items</h4>

                <table class="table table-bordered" id="lineItemsTable">
                  <thead class="thead-light">
                    <tr>
                      <th>Medicine Name</th>
                      <th>Quantity</th>
                      <th>Purchase Price (per unit)</th>
                      <th>Sale Price (per unit)</th>
                      <th>Subtotal (Sale)</th>
                      <th>Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Existing line items (if any) -->
                    <?php if (!empty($lineItems)): ?>
                      <?php foreach ($lineItems as $idx => $item): ?>
                        <tr>
                          <td>
                            <input
                              type="text"
                              class="form-control"
                              name="medicine_name[]"
                              value="<?= esc($item['medicine_name'] ?? '') ?>"
                              placeholder="Enter medicine name"
                            />
                          </td>
                          <td>
                            <input
                              type="number"
                              class="form-control"
                              name="quantity[]"
                              value="<?= esc($item['quantity'] ?? '1') ?>"
                              min="1"
                              oninput="calcSubtotal(this)"
                            />
                          </td>
                          <td>
                            <input
                              type="text"
                              class="form-control"
                              name="purchase_price[]"
                              value="<?= esc($item['purchase_price'] ?? '0.00') ?>"
                              oninput="calcSubtotal(this)"
                            />
                          </td>
                          <td>
                            <input
                              type="text"
                              class="form-control"
                              name="sale_price[]"
                              value="<?= esc($item['sale_price'] ?? '0.00') ?>"
                              oninput="calcSubtotal(this)"
                            />
                          </td>
                          <td class="subtotalCell align-middle">
                            <?php
                              $subSale =
                                ($item['quantity'] ?? 1) *
                                ($item['sale_price'] ?? 0.00);
                              echo number_format($subSale, 2);
                            ?>
                          </td>
                          <td class="text-center align-middle">
                            <button
                              type="button"
                              class="btn btn-danger btn-sm"
                              onclick="removeRow(this)"
                            >
                              X
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Blank row for a new item -->
                    <tr>
                      <td>
                        <input
                          type="text"
                          class="form-control"
                          name="medicine_name[]"
                          placeholder="Enter medicine name"
                          value=""
                        />
                      </td>
                      <td>
                        <input
                          type="number"
                          class="form-control"
                          name="quantity[]"
                          value="1"
                          min="1"
                          oninput="calcSubtotal(this)"
                        />
                      </td>
                      <td>
                        <input
                          type="text"
                          class="form-control"
                          name="purchase_price[]"
                          value="0.00"
                          oninput="calcSubtotal(this)"
                        />
                      </td>
                      <td>
                        <input
                          type="text"
                          class="form-control"
                          name="sale_price[]"
                          value="0.00"
                          oninput="calcSubtotal(this)"
                        />
                      </td>
                      <td class="subtotalCell align-middle">0.00</td>
                      <td class="text-center align-middle">
                        <button
                          type="button"
                          class="btn btn-danger btn-sm"
                          onclick="removeRow(this)"
                        >
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <button
                  type="button"
                  class="btn btn-secondary"
                  onclick="addRow()"
                >
                  + Add Another Medicine
                </button>

                <hr />

                <!-- Invoice Upload Option -->
                <div class="form-group mt-4">
                  <label for="invoice_file">Upload Invoice (PDF/Image):</label>
                  
                  <!-- If there's an existing invoice_path, show a link -->
                  <?php if (!empty($existingInvoice)): ?>
                    <p>Existing Invoice:
                      <a href="<?= base_url("public/".$existingInvoice) ?>" target="_blank">
                        <?= basename($existingInvoice) ?>
                      </a>
                    </p>
                  <?php endif; ?>
                  
                  <input
                    type="file"
                    class="form-control"
                    name="invoice_file"
                    id="invoice_file"
                    accept="application/pdf,image/*"
                  />
                </div>
                
                <!-- Let the user explicitly enter the final total amount -->
                <div class="form-group">
                  <label for="total_amount">Total Amount (Sale):</label>
                  <input
                    type="text"
                    class="form-control"
                    name="total_amount"
                    id="total_amount"
                    placeholder="Enter final total sale amount"
                    value="<?= esc($existingTotalAmt) ?>"
                  />
                </div>


                <div class="mt-4">
                  <button type="submit" class="btn btn-primary">
                    Save &amp; Inform User
                  </button>
                </div>
              </form>
              <!-- End of form -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content -->
</div>

<!-- JavaScript for dynamic row addition and subtotal calculation -->
<script>
  function addRow() {
    const tableBody = document.querySelector('#lineItemsTable tbody');
    // Last row is presumably the "blank" template row
    const lastRow = tableBody.lastElementChild;
    // Clone it
    const clone = lastRow.cloneNode(true);

    // Reset the fields in the clone
    clone.querySelector('input[name="medicine_name[]"]').value = '';
    clone.querySelector('input[name="quantity[]"]').value = 1;
    clone.querySelector('input[name="purchase_price[]"]').value = '0.00';
    clone.querySelector('input[name="sale_price[]"]').value = '0.00';
    clone.querySelector('.subtotalCell').textContent = '0.00';

    // Append the cloned row
    tableBody.appendChild(clone);
  }

  function removeRow(button) {
    const row = button.closest('tr');
    const tableBody = row.parentNode;
    if (tableBody.children.length > 1) {
      row.remove();
    }
  }

  function calcSubtotal(input) {
    const row = input.closest('tr');
    const qty = parseFloat(
      row.querySelector('input[name="quantity[]"]').value
    ) || 0;
    const salePrice = parseFloat(
      row.querySelector('input[name="sale_price[]"]').value
    ) || 0;

    const subtotal = qty * salePrice;
    row.querySelector('.subtotalCell').textContent = subtotal.toFixed(2);
  }
</script>

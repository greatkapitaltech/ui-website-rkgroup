<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id',
        'order_id',
        'prescription_path',
        'invoice_path',     // <--- NEW: path of the uploaded invoice file
        'status',
        'total_amount',     // total sale amount
        'total_purchase',   // total purchase cost (if you added this column)
        'created_at',
        'updated_at'
    ];

    /**
     * Create a new order record.
     * 
     * @param int    $userId
     * @param string $orderId
     * @param string $prescriptionPath
     * 
     * @return int|false ID of inserted row or false on failure
     */
    public function createOrder($userId, $orderId, $prescriptionPath = null)
    {
        $data = [
            'user_id'          => $userId,
            'order_id'         => $orderId,
            'prescription_path'=> $prescriptionPath,
            'status'           => 'pending',
        ];

        return $this->insert($data);
    }

    /**
     * Retrieve an order by the custom order_id string.
     */
    public function getOrderByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->first();
    }

    /**
     * Update the status of an order by DB ID.
     */
    public function updateStatus($orderDbId, $status)
    {
        return $this->update($orderDbId, ['status' => $status]);
    }

    /**
     * Update the prescription path of an order by DB ID.
     */
    public function updatePrescriptionPath($orderDbId, $path)
    {
        return $this->update($orderDbId, ['prescription_path' => $path]);
    }

    /**
     * Update the invoice path if an admin uploads an invoice.
     */
    public function updateInvoicePath($orderDbId, $invoicePath)
    {
        return $this->update($orderDbId, ['invoice_path' => $invoicePath]);
    }

    /**
     * Update total_purchase or total_amount if needed.
     */
    public function updateTotals($orderDbId, $purchase, $sale)
    {
        return $this->update($orderDbId, [
            'total_purchase' => $purchase,
            'total_amount'   => $sale
        ]);
    }
}

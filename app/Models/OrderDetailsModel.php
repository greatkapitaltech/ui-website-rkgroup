<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model
{
    protected $table         = 'order_details';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'order_id',
        // 'medicine_id',   // Uncomment if you actually store references
        'medicine_name',
        'quantity',
        'purchase_price',  // <--- NEW
        'sale_price'       // <--- NEW
    ];

    /**
     * Get all line items for a specific order
     */
    public function getOrderDetailsByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->findAll();
    }

    /**
     * Insert multiple order details at once
     */
    public function insertBatchDetails(array $data)
    {
        // $data is an array of arrays, each with keys:
        //   'order_id','medicine_name','quantity','purchase_price','sale_price'
        return $this->insertBatch($data);
    }

    /**
     * (Optional) Calculate total purchase & sale for a given order.
     */
    public function calculateTotals($orderId)
    {
        $items = $this->getOrderDetailsByOrderId($orderId);
        $totalPurchase = 0.0;
        $totalSale     = 0.0;

        foreach ($items as $item) {
            $qty       = (float)$item['quantity'];
            $pPrice    = (float)($item['purchase_price'] ?? 0);
            $sPrice    = (float)($item['sale_price'] ?? 0);

            $totalPurchase += ($qty * $pPrice);
            $totalSale     += ($qty * $sPrice);
        }

        return [
            'total_purchase' => $totalPurchase,
            'total_sale'     => $totalSale
        ];
    }
}

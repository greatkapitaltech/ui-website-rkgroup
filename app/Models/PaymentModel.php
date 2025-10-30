<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'payment_status',
        'amount_paid',
        'payment_link',
        'paid_at',
        'created_at'
    ];

    public function createPaymentRecord($orderDbId, $paymentLink)
    {
        $data = [
            'order_id'       => $orderDbId,
            'payment_status' => 'pending',
            'payment_link'   => $paymentLink,
        ];
        return $this->insert($data);
    }

    public function markAsPaid($id, $amountPaid)
    {
        $this->update($id, [
            'payment_status' => 'paid',
            'amount_paid'    => $amountPaid,
            'paid_at'        => date('Y-m-d H:i:s')
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryAddressModel extends Model
{
    protected $table = 'delivery_addresses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'recipient',
        'address_text',
        'google_map_link',
        'shared_location',
        'created_at'
    ];

    public function createAddress($orderId, $recipient, $addressText = null, $mapLink = null, $location = null)
    {
        $data = [
            'order_id'       => $orderId,
            'recipient'      => $recipient,
            'address_text'   => $addressText,
            'google_map_link'=> $mapLink,
            'shared_location'=> $location
        ];
        return $this->insert($data);
    }
}

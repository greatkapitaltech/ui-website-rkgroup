<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class CouponModel extends Model
{
    protected $table            = 'customer_coupons';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'customer_name', 'customer_pincode', 'customer_number',
        'coupon_code', 'status',
        'valid_from', 'valid_to',
        'usage_limit_per_coupon', 'usage_count', 'usage_limit_per_customer',
        'redeemed_at', 'account_id',
        'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'customer_name'  => 'required|min_length[2]|max_length[120]',
        'customer_pincode' => 'required|min_length[4]|max_length[10]',
        'customer_number'  => 'required|min_length[7]|max_length[20]',
        'coupon_code'      => 'required|min_length[3]|max_length[64]|is_unique[customer_coupons.coupon_code,id,{id}]',
        'status'           => 'permit_empty|in_list[active,inactive,expired,used_up]',
        'usage_limit_per_coupon' => 'required|integer|greater_than[0]',
        'usage_count'      => 'permit_empty|integer|greater_than_equal_to[0]'
    ];

    protected function beforeInsert(array $data) { return $this->normalize($data); }
    protected function beforeUpdate(array $data) { return $this->normalize($data); }

    private function normalize(array $data): array
    {
        if (isset($data['data']['coupon_code'])) {
            $data['data']['coupon_code'] = strtoupper(trim($data['data']['coupon_code']));
        }
        if (isset($data['data']['customer_number'])) {
            $data['data']['customer_number'] = preg_replace('/\s+/', '', $data['data']['customer_number']);
        }
        return $data;
    }

    public function isValidForUse(array $coupon, ?string $customerNumber = null): bool
    {
        if ($coupon['status'] !== 'active') return false;

        $now = new DateTime();
        if (!empty($coupon['valid_from']) && $now < new DateTime($coupon['valid_from'])) return false;
        if (!empty($coupon['valid_to']) && $now > new DateTime($coupon['valid_to'])) return false;

        if ((int)$coupon['usage_count'] >= (int)$coupon['usage_limit_per_coupon']) return false;

        if ($coupon['usage_limit_per_customer'] !== null && $customerNumber !== null) {
            // optional per-customer logic (e.g., track in metadata in future)
        }

        return true;
    }

    public function markRedeemed(int $id): bool
    {
        $coupon = $this->find($id);
        if (!$coupon) return false;

        $newCount = (int)$coupon['usage_count'] + 1;
        $status   = $coupon['status'];

        if ($newCount >= (int)$coupon['usage_limit_per_coupon']) {
            $status = 'used_up';
        }

        return $this->update($id, [
            'usage_count' => $newCount,
            'redeemed_at' => date('Y-m-d H:i:s'),
            'status'      => $status
        ]);
    }
}

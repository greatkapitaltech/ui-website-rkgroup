<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderSequenceModel extends Model
{
    protected $table            = 'order_sequences';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['year', 'month', 'last_sequence'];

    // Example: No timestamps in this table, so you can turn them off if you like
    public $useTimestamps = false;

    /**
     * Retrieve the sequence row for given year/month.
     */
    public function getSequenceRow($year, $month)
    {
        return $this->where('year', $year)
                    ->where('month', $month)
                    ->first(); 
    }

    /**
     * Create a new sequence row for a particular year/month, setting the initial last_sequence value.
     */
    public function createSequenceRow($year, $month, $sequence = 1)
    {
        $data = [
            'year'          => $year,
            'month'         => $month,
            'last_sequence' => $sequence,
        ];
        return $this->insert($data); 
    }

    /**
     * Update the last_sequence for a given year/month.
     */
    public function updateSequence($year, $month, $newSequence)
    {
        return $this->where('year', $year)
                    ->where('month', $month)
                    ->set(['last_sequence' => $newSequence])
                    ->update();
    }
}

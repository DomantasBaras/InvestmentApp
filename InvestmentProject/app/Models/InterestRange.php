<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestRange extends Model
{
    protected $fillable = [
        'min_amount',
        'max_amount',
        'interest_rate'
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2'
    ];

    // Find applicable interest rate for given amount
    public static function findRateForAmount(float $amount): ?float
    {
        $range = self::where('min_amount', '<=', $amount)
            ->where('max_amount', '>=', $amount)
            ->first();

        return $range ? $range->interest_rate : null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use App\Models\PaymentSchedule;

class Investment extends Model
{
    protected $fillable = [
        'amount',
        'rounded_amount',
        'interest_rate',
        'start_date',
        'end_date',
        'status',
        'user_id', 
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'rounded_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function paymentSchedules(): HasMany
    {
        return $this->hasMany(PaymentSchedule::class);
    }

    // Calculate total interest to be paid
    public function getTotalInterestAttribute(): float
    {
        return $this->paymentSchedules()
            ->where('payment_type', 'interest')
            ->sum('interest_amount');
    }

    // Calculate total return (principal + interest)
    public function getTotalReturnAttribute(): float
    {
        return $this->rounded_amount + $this->total_interest;
    }


    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getProgressPercentageAttribute(): float
    {
        $totalDays = $this->start_date->diffInDays($this->end_date);
        $daysPassed = $this->start_date->diffInDays(now());
        return min(100, ($daysPassed / $totalDays) * 100);
    }

    public function getRemainingPrincipalAttribute(): float
    {
        return $this->rounded_amount;
    }

    public function getNextPaymentAttribute(): ?PaymentSchedule
    {
        return $this->paymentSchedules()
            ->where('is_paid', false)
            ->orderBy('payment_date')
            ->first();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function view(User $user, Investment $investment)
    {
        return $user->id === $investment->user_id;  
    }
}

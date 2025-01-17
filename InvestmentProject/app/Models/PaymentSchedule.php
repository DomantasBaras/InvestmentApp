<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentSchedule extends Model
{
    protected $fillable = [
        'investment_id',
        'payment_date',
        'interest_amount',
        'payment_type',
        'is_paid'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'interest_amount' => 'decimal:2',
        'is_paid' => 'boolean'
    ];

    // Relationship with investment
    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }

    // Scope for interest payments
    public function scopeInterestPayments($query)
    {
        return $query->where('payment_type', 'interest');
    }

    // Scope for principal payments
    public function scopePrincipalPayments($query)
    {
        return $query->where('payment_type', 'principal');
    }

    // Mark payment as paid
    public function markAsPaid(): void
    {
        $this->update(['is_paid' => true]);
    }

    // Check if payment is overdue
    public function isOverdue(): bool
    {
        return !$this->is_paid && $this->payment_date < now();
    }

    // Get formatted amount
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->interest_amount, 2) . ' EUR';
    }
}
<?php
namespace App\Services;

use App\Models\Investment;
use App\Models\InterestRange;
use App\ValueObjects\Money;
use Carbon\Carbon;

class InvestmentService
{
    public function createInvestment(float $amount, Carbon $startDate, ?int $userId = null): Investment
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            throw new \Exception('User not authenticated');
        }

        $money = new Money($amount);
        $roundedMoney = $money->roundToHundred();
        
        $interestRate = $this->calculateInterestRate($roundedMoney->getAmount());
        
        return Investment::create([
            'amount' => $money->getAmount(),
            'rounded_amount' => $roundedMoney->getAmount(),
            'interest_rate' => $interestRate,
            'start_date' => $startDate,
            'end_date' => $startDate->copy()->addYear(),
            'user_id' => $userId,
        ]);
    }

    private function calculateInterestRate(float $amount): float
    {
        return InterestRange::where('min_amount', '<=', $amount)
            ->where('max_amount', '>=', $amount)
            ->value('interest_rate');
    }
}
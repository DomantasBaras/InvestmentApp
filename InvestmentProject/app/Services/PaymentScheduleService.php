<?php
namespace App\Services;

use App\Models\Investment;
use App\Models\PaymentSchedule;
use Carbon\Carbon;

class PaymentScheduleService
{
    public function generateSchedule(Investment $investment): void
    {
        $startDate = Carbon::parse($investment->start_date);
        
        // Generate quarterly interest payments
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $paymentDate = $startDate->copy()->addMonths($quarter * 3);
            
            $interestAmount = $investment->rounded_amount * 
                ($investment->interest_rate / 100) * 
                (3 / 12); // Quarterly interest
            
            PaymentSchedule::create([
                'investment_id' => $investment->id,
                'payment_date' => $paymentDate,
                'interest_amount' => $interestAmount,
                'payment_type' => 'interest'
            ]);
        }
        
        // Add principal payment at the end
        PaymentSchedule::create([
            'investment_id' => $investment->id,
            'payment_date' => $investment->end_date,
            'interest_amount' => $investment->rounded_amount,
            'payment_type' => 'principal'
        ]);
    }
}
<?php

namespace Tests\Unit\Services;

use App\Models\Investment;
use App\Models\InterestRange;
use App\Services\InvestmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvestmentServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_investment_with_correct_interest_rate()
    {
        // Manually seed InterestRange data
        InterestRange::create([
            'min_amount' => 0,
            'max_amount' => 100,
            'interest_rate' => 5,
        ]);

        InterestRange::create([
            'min_amount' => 101,
            'max_amount' => 1000,
            'interest_rate' => 6,
        ]);

        // Setup
        $investmentService = new InvestmentService();
        $amount = 150;
        $startDate = Carbon::now();

        // Call the method
        $investment = $investmentService->createInvestment($amount, $startDate);

        // Assertions
        $this->assertInstanceOf(Investment::class, $investment);
        $this->assertEquals($amount, $investment->amount);
        $this->assertEquals(200, $investment->rounded_amount); // Assuming rounding up to the nearest 100
        $this->assertEquals(6, $investment->interest_rate); // Based on the ranges seeded
        $this->assertEquals($startDate->toDateString(), $investment->start_date->toDateString());
        $this->assertEquals($startDate->copy()->addYear()->toDateString(), $investment->end_date->toDateString());
    }
}

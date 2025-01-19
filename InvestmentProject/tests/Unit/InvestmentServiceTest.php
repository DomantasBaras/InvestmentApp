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
 /** @test */
    public function it_creates_an_investment_with_correct_interest_rate()
    {
        // Create a user for the test
        $user = \App\Models\User::factory()->create();

        // Seed InterestRange data
        InterestRange::create([
            'min_amount' => 0,
            'max_amount' => 100,
            'interest_rate' => 5.0,
        ]);

        InterestRange::create([
            'min_amount' => 101,
            'max_amount' => 1000,
            'interest_rate' => 6.0,
        ]);

        // Setup
        $investmentService = new InvestmentService();
        $amount = 150;
        $startDate = Carbon::now();

        // Call the method
        $investment = $investmentService->createInvestment($amount, $startDate, $user->id);

        // Assertions
        $this->assertInstanceOf(Investment::class, $investment);
        $this->assertEquals($user->id, $investment->user_id);
        $this->assertEquals($amount, $investment->amount);
        $this->assertEquals(200, $investment->rounded_amount); // Assuming rounding up to the nearest 100
        $this->assertEquals(6.0, $investment->interest_rate); // Based on the ranges seeded
        $this->assertEquals($startDate->toDateString(), $investment->start_date->toDateString());
        $this->assertEquals($startDate->copy()->addYear()->toDateString(), $investment->end_date->toDateString());
    }

}

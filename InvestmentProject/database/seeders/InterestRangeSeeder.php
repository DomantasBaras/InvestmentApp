<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InterestRange;

class InterestRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InterestRange::create([
            'min_amount' => 0,
            'max_amount' => 100,
            'interest_rate' => 5
        ]);

        InterestRange::create([
            'min_amount' => 100,
            'max_amount' => 1000,
            'interest_rate' => 6
        ]);

        InterestRange::create([
            'min_amount' => 1000,
            'max_amount' => 5000,
            'interest_rate' => 7
        ]);
    }
}

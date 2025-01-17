<?php

namespace App\ValueObjects;

class Money
{
    public function __construct(
        private float $amount,
        private string $currency = 'EUR'
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function roundToHundred(): self
    {
        $roundedAmount = ceil($this->amount / 100) * 100;
        return new self($roundedAmount, $this->currency);
    }
}
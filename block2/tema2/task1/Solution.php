<?php

declare(strict_types=1);

namespace Task1;

class BankAccount
{
    private float $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($this->balance < $amount) {
            throw new \RuntimeException('Недостаточно средств');
        }
        $this->balance -= $amount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}


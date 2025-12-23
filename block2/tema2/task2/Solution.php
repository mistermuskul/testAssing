<?php

declare(strict_types=1);

namespace Task2;

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

    protected function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}

class SavingsAccount extends BankAccount
{
    private float $interestRate;

    public function __construct(float $balance, float $interestRate)
    {
        parent::__construct($balance);
        $this->interestRate = $interestRate;
    }

    public function applyInterest(): void
    {
        $currentBalance = $this->getBalance();
        $interest = $currentBalance * ($this->interestRate / 100);
        $this->deposit($interest);
    }
}


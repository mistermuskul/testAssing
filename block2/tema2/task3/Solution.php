<?php

declare(strict_types=1);

namespace Task3;

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

class CreditAccount extends BankAccount
{
    public function withdraw(float $amount): void
    {
        $this->setBalance($this->getBalance() - $amount);
    }
}


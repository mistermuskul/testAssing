<?php

declare(strict_types=1);

namespace Task5;

trait Loggable
{
    public function log(string $message): void
    {
        echo "[LOG]: {$message}\n";
    }
}

class Car
{
    use Loggable;

    private string $brand;
    private string $model;
    private int $year;

    public function __construct(string $brand, string $model, int $year)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function getCarInfo(): string
    {
        return "{$this->brand} {$this->model}, {$this->year}";
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}


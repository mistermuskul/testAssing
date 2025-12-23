<?php

declare(strict_types=1);

namespace Task1;

class Car
{
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
}


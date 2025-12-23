<?php

declare(strict_types=1);

namespace Task3;

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

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}

class ElectricCar extends Car
{
    private int $batteryCapacity;

    public function __construct(string $brand, string $model, int $year, int $batteryCapacity)
    {
        parent::__construct($brand, $model, $year);
        $this->batteryCapacity = $batteryCapacity;
    }

    public function getBatteryInfo(): string
    {
        return "Батарея: {$this->batteryCapacity} kWh";
    }
}


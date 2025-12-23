<?php

declare(strict_types=1);

namespace Task4;

interface Movable
{
    public function move(): string;
}

class Car implements Movable
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

    public function move(): string
    {
        return "Машина едет";
    }
}

class Bicycle implements Movable
{
    public function move(): string
    {
        return "Велосипед движется";
    }
}


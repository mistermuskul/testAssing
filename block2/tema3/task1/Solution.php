<?php

declare(strict_types=1);

namespace Task1;

abstract class Shape
{
    abstract public function getArea(): float;
}

class Rectangle extends Shape
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getArea(): float
    {
        return $this->width * $this->height;
    }
}

class Circle extends Shape
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function getArea(): float
    {
        return round(M_PI * $this->radius * $this->radius, 2);
    }
}


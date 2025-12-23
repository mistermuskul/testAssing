<?php

declare(strict_types=1);

namespace Task2;

interface Drawable
{
    public function draw(): void;
}

abstract class Shape
{
    abstract public function getArea(): float;
}

class Rectangle extends Shape implements Drawable
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

    public function draw(): void
    {
        echo "Рисую прямоугольник шириной {$this->width} и высотой {$this->height}\n";
    }
}

class Circle extends Shape implements Drawable
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

    public function draw(): void
    {
        echo "Рисую круг радиусом {$this->radius}\n";
    }
}


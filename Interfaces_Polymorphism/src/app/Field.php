<?php

namespace App;

abstract class Field implements Renderable
{
    public function __construct(
        protected string $name,
        protected int $size,
        protected string $type
    ) {
    }

    // abstract public function render(): string;
}
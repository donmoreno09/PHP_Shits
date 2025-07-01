<?php

namespace App;

interface DebtCollector
{
    public function collect(float $amount): float;
}
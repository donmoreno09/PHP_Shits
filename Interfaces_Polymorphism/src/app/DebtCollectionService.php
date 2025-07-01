<?php

namespace App;

class DebtCollectionService

{
    public function collectDebt(DebtCollector $collector)
    {
        $owedAmount = mt_rand(1000, 5000); // Random amount between 1000 and 5000
        $collectedAmount = $collector->collect($owedAmount);

        echo 'Collected $' . $collectedAmount . ' out of $' . $owedAmount . PHP_EOL;
    }
}
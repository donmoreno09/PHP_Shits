<?php

namespace App;

class CollectionAgency implements DebtCollector
{

    public function collect(float $owedAmount): float
    {
       
        $guaranteed = $owedAmount * 0.9; // 90% of the owed amount

        return mt_rand($guaranteed, $owedAmount);
    }
}
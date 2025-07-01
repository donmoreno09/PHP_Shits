<?php



require __DIR__ . '/../vendor/autoload.php';

// $collector = new \App\CollectionAgency();

// echo $collector->collect(1000) . PHP_EOL;

$service = new \App\DebtCollectionService();

echo $service->collectDebt(new \App\Rocky()) . PHP_EOL;
<?php



require __DIR__ . '/../vendor/autoload.php';

$invoice = new \App\Invoice();

echo $invoice->amount . PHP_EOL;
<?php

require __DIR__ . '/../vendor/autoload.php';

use App\PaymentGateway\Paddle\Transaction;


$transaction = new Transaction(25, 'Transaction 1');
$transaction = new Transaction(25, 'Transaction 1');
$transaction = new Transaction(25, 'Transaction 1');
$transaction = new Transaction(25, 'Transaction 1');
$transaction = new Transaction(25, 'Transaction 1');

var_dump($transaction::getCount()); // Accessing the static property
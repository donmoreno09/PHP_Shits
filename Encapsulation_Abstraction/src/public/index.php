<?php

require __DIR__ . '/../vendor/autoload.php';

use App\PaymentGateway\Paddle\Transaction;


$transaction = new Transaction(25);

$transaction->process();
<?php

require_once '../PaymentGateway/Stripe/Transaction.php';
require_once '../PaymentGateway/Paddle/CustomerProfile.php';
require_once '../Notification/Email.php';
require_once '../PaymentGateway/Paddle/Transaction.php';

use PaymentGateway\Paddle\Transaction;

// var_dump(new \PaymentGateway\Stripe\Transaction()); # Solo quando non usi 'Use'

var_dump(new Transaction());
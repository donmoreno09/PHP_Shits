<?php

require __DIR__ . '/../vendor/autoload.php';

use App\ToasterPro;

$toaster = new ToasterPro();
$toaster->addSlice('Bread');
$toaster->addSlice('Bread');
$toaster->addSlice('Croissant');
$toaster->toast();
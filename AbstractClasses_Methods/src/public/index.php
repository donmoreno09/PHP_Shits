<?php

use App\Text;
use App\Checkbox;
use App\Radio;

require __DIR__ . '/../vendor/autoload.php';

$fields = [
    new Text('text'),
    new Checkbox('checkbox'),
    new Radio('radio')
];

foreach ($fields as $field) {
    echo $field->render();
}
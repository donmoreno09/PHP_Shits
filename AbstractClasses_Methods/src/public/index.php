<?php

require __DIR__ . '/../vendor/autoload.php';

$fields = [
    new \App\Text('text'),
    new \App\Checkbox('checkbox'),
    new \App\Radio('radio')
];

foreach ($fields as $field) {
    echo $field->render();
}
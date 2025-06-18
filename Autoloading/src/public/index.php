<?php


// spl_autoload_register(function($class){
//     $path = __DIR__ . '/../' . lcfirst(str_replace('\\' , '/', $class) . '.php');
//     # __DIR__ è la directory corrente del file che sta eseguendo il codice
//     if(file_exists($path)) {
//         require $path;
//     } else {
//         throw new \Exception("File not found: " . $path);
//     }
// });
// All'inizio sto configurando l'autoloading senza usare composer

// Ora uso composer per l'autoloading, per poterlo fare i passi sono: 
// 1. Installare composer
// 2.  Ho lanciato composer require ramsey/uuid
// 3. Ho messo require __DIR__ . '/../vendor/autoload.php'; per caricare l'autoloader di composer
 /* 4. Sono andato su composer.json e ho aggiunto "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    } */
// 5. Vado su Vendor/Composer/autoload_psr4.php e vedo che è stato aggiunto il namespace App con la cartella app
// 6. Se non è statao aggiunto lo devo lanciare il comando composer dump-autoload e poi ricontrollare

# composer dump-autoload -o is used to optimize the autoloader for production

require __DIR__ . '/../vendor/autoload.php';

use App\PaymentGateway\Paddle\Transaction;


$paddleTransaction = new Transaction();

$id = new \Ramsey\Uuid\UuidFactory();
echo $id->uuid4();

var_dump($paddleTransaction);

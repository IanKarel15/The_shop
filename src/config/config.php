<?php

require __DIR__.'/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load(); //Creo que aquí se extraen los datos del .env

return[
     'base_url' => $_ENV['APP_URL'],
    'assets_url' => $_ENV['APP_URL'].'/assets',
    'db' => [
        //Aquí van los datos del extraídos del .env
        'host' => $_ENV['DB_HOST'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
        'charset' => $_ENV['CHARSET'],
        'port' => $_ENV['DB_PORT'],
        'name' => $_ENV['DB_NAME']
        //Despues de obtener los datos se usan en database.php para hacer la conexión a la base de datos
    ]
];

?>
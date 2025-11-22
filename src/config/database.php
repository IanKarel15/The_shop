<?php


function getPDO() : PDO { //Función para conectar a la base de datos si no hay ya una conexión y regresarla (return )
    
    static $pdo = null;
    
    if ($pdo === null) {
        $config = require __DIR__.'/config.php';
        $db = $config['db'];

        try{
            $pdo = new PDO( //Constructor de PDO
                "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}", //dsn (host, database name, charset)
                $db['user'], //Usuario
                $db['pass'] //Contraseña
            );
        } catch (PDOException $e){
            die("Error al conectar con la base de datos: ".e->getMessage());
        }
    }

    return $pdo; //Regresa la conexión
}



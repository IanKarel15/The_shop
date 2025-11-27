<?php 

$config = require __DIR__.'/../config/config.php';
require __DIR__.'/../config/database.php';


define('BASE_PATH', $config['base_url']);
define('ASSETS_PATH', $config['assets_url']);

function view($template, $data = [])
{
    // Convierte cada clave del array en una variable
    extract($data);

    // Rutas absolutas
    $viewsPath = __DIR__ . '/../views/';
    $layoutPath = $viewsPath . 'layouts/';

    // Vista solicitada
    require $viewsPath . $template . '.php';

}

function redirect($path) {
    header('Location: '.BASE_PATH.'/'.$path);
    exit;
}

?>
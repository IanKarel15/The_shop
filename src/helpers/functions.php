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

function uploadImage($file, $folder) {
    // Si no hay archivo o hubo error, no guardar nada
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

   
    $uploadDir = __DIR__ . "/../../public/$folder/";

    // Crear carpeta si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $originalName = $file['name'];
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);

    $imageName = uniqid($folder . '_') . '.' . $extension;

    // Mover archivo
    $tmpPath = $file['tmp_name'];
    move_uploaded_file($tmpPath, $uploadDir . $imageName);

    return $imageName;
}

function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function requireAuth() {
    if(!isAuthenticated()) {
        header("Location: ".BASE_PATH."/login");
    }
}

function deleteImage($folder, $filename)
{
    
    $path = __DIR__ . "/../../public/assets/$folder/$filename";

    if ($filename && file_exists($path)) {
        unlink($path);
    }
}


function isAdmin() {
    
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}
?>
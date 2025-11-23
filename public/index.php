<?php 

require_once __DIR__ . '/../src/helpers/functions.php';
require_once __DIR__.'/../src/Models/Product.php';
// Obtener ruta limpia desde $_GET['route']
$route = trim($_GET['route'] ?? '', '/');
$method = $_SERVER['REQUEST_METHOD'];

if ($route === '' || $route === 'home') {
    $productModel = new Product(getPDO());
    $products = $productModel->getAll();
    return view('home/index', ['products' => $products]);
}

  
?>
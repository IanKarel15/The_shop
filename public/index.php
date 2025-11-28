<?php 

require __DIR__ . '/../src/helpers/functions.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ProductController;

$route = trim($_GET['route'] ?? '', '/');
$method = $_SERVER['REQUEST_METHOD'];

if ($route === '' || $route === 'home') { 
   if($method === 'GET') {
    // CORREGIDO: Usamos ProductController
    return (new ProductController())->index();
  }
}

if (preg_match('#^products/(\d+)$#', $route, $matches)) {
  $productId = filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT);

  if($method ===  'GET') {
    return (new ProductController())->show($productId);
  }
}

if($route === 'admin/index') {
  return (new ProductController())->adminIndex();
}

if (preg_match('#^admin/products/delete/(\d+)$#', $route, $matches)) {
    $productId = filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT);
    return (new ProductController())->delete($productId);
}

if($route === 'admin/products/create') {

  if($method === 'POST') {
    return (new ProductController())->store($_POST, $_FILES);
  }

  return (new ProductController())->form();
}




http_response_code(404);
return view('errors/error');
  
?>
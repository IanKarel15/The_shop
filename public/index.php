<!-- Este archivo es el enrutador, dependiendo lo que reciba en el route mandara una vista -->

<?php 

if(session_status() === PHP_SESSION_NONE){
  session_start();
}

require __DIR__ . '/../src/helpers/functions.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ProductController;
use App\Controllers\AuthController;

$route = trim($_GET['route'] ?? '', '/');
$method = $_SERVER['REQUEST_METHOD'];

if(str_starts_with($route, "admin/")) {
    requireAuth();
}

//Cuando el route venga vacio o con home lo mandaremos al index donde se muestran todos los productos 
if ($route === '' || $route === 'home') { 
   if($method === 'GET') {
    return (new ProductController())->index();
  }
}

if($route === 'login') {
  if($method === 'POST') {
    return (new AuthController())->attemptLogin($_POST['username'], $_POST['password']);
  }

  if(!isAuthenticated()) {
    return view('auth/login');
  }

  redirect('admin/index');
}

if($route === 'logout') {
  return (new AuthController())->logout();
}

//Cuando el route venga con un id lo mandaremos a mostrar los detalles del producto
if (preg_match('#^products/(\d+)$#', $route, $matches)) {
  $productId = filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT);

  if($method ===  'GET') {
    return (new ProductController())->show($productId);
  }
}

//Cuando el route contenga admin/index lo mandaremos a la pantalla del administrador
if($route === 'admin/index') {
  return (new ProductController())->adminIndex();
}

//Cuando el route venga con delete y un id lo mandaremos a eliminar el producto 
if (preg_match('#^admin/products/delete/(\d+)$#', $route, $matches)) {
    $productId = filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT);
    return (new ProductController())->delete($productId);
}

//Cuando el route venga con create y si viene con el metodo post guardaremos el producto en la base de datos 
if($route === 'admin/products/create') {

  if($method === 'POST') {
    return (new ProductController())->store($_POST, $_FILES);
  }

  return (new ProductController())->form();
}

//Cuando el route venga con un edit lo mandamos  al metodo update preguntando si en el metodo trae un put, si no mandamos a editarlo 
if (preg_match('#^admin/products/edit/(\d+)$#', $route, $matches)) {
    $productId = filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT);
   
    if(($_POST['_method'] ?? '') === 'PUT') {
        return (new ProductController())->update($productId, $_POST, $_FILES);
    }

    return (new ProductController())->form($productId);
}




//Cuando el route de error 404 mandamos a la pantalla de error
http_response_code(404);
return view('errors/error');
  
?>
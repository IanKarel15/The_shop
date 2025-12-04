<?php 

namespace App\Controllers;
use App\Models\Cart;

class CarritoController{
    public function index() {
        $carritoModel = new Cart(getPDO());
        $products = $carritoModel->getAll(); 

        $total = $carritoModel->total();
        
        return view('vistasCarrito/carrito', ['products' => $products, 'total' => $total]);
    }
}

?>
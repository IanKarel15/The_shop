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

    public function add($data) {

        $carritoModel = new Cart(getPDO());
        
        $product_id = $data['id'];
        $size_id = $data['size_id'];
        $quantity = $data['quantity'];

        $carritoModel->add($product_id, $size_id, $quantity);
       
        redirect("products/{$product_id}");

    }

    
    public function delete($id,$size_id)
    {
        $carritoModel = new Cart(getPDO());
        $carritoModel->delete($id,$size_id);
        redirect('carrito');
    }
    public function comprar()
    {
        $carritoModel = new Cart(getPDO());
        $products = $carritoModel->getAll(); 

        $total = $carritoModel->total();
        return view('vistasCarrito/pantallaPago', ['products' => $products, 'total' => $total]);
    }

    public function comprado()
    {
        $carritoModel = new Cart(getPDO());
        
        $carritoModel->buyAll(); 

        return view('vistasCarrito/pantallaPago', ['success' => true]);
    }
}

?>
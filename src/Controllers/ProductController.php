<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController {

    public function index() {
        $productModel = new Product(getPDO());
        $products = $productModel->getAll(); 
        
        return view('home/index', ['products' => $products]);
    }

    public function show($id) {
        $productModel = new Product(getPDO());
        $product = $productModel->getProductDetails($id);
        return view('products/productInfo', ['product' => $product]);
    }


}

?>
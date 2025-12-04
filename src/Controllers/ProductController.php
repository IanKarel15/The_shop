<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController {

    public function index() {
        $productModel = new Product(getPDO());
        $products = $productModel->getAll(); 
        
        return view('home/index', ['products' => $products]);
    }

    public function filterByCategory ($category) {
        $products = (new Product())->filterByCategory($category);

        return view('home/index', ['products' => $products]);
    }

    public function show($id) {
        $productModel = new Product(getPDO());
        $product = $productModel->getProductDetails($id);
        return view('products/productInfo', ['product' => $product]);
    }

    public function adminIndex() {
        $productModel = new Product(getPDO());
        $products = $productModel->getAll(); 
        
        return view('admin/index', ['products' => $products]);
    }

     public function delete($id)
    {
        $product = new Product(getPDO());
        $product->delete($id);

        return redirect('admin/index');
    }

    public function form($id = null) {
        $productData = null;

        if($id) {
            $product = new Product(getPDO());
            $productData = $product->getProductDetails($id);
        }

        return view('admin/form', ['product' => $productData]);
    }

    public function store($data, $files) {

        $product = new Product(getPDO());

        $imageName = uploadImage($files['image'], 'assets');

        $data['image'] = $imageName;

        $product->add($data['name'], $data['price'], $data['description'], $data['image']);

        return redirect('/admin/index');

    }

    public function update($id, $post, $files)
    {
        $product = new Product(getPDO());

        $current = $product->getProductDetails($id);
        $imageName = $current->imageURL; 

        if (!empty($files['image']['name'])) {

            $newImage = uploadImage($files['image'], 'img');

            if ($newImage) {
                deleteImage('img', $current->imageURL);
                $imageName = $newImage;
            }
        }
       

       $product->edit($post['id'],$post['name'], $post['price'], $post['description'], $imageName);

        return redirect('admin/index');
    }


}

?>
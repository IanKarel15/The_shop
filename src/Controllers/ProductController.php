<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController {

    public function index() {
        $productModel = new Product(getPDO());
        $products = $productModel->getAll(); 
        
        return view('home/index', ['products' => $products]);
    }

    public function search ($filter) {
        $products = (new Product())->search($filter);

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

        $inv = $data['inventory'] ?? [];
        $s   = $inv['S'] ?? 0;
        $m   = $inv['M'] ?? 0;
        $l   = $inv['L'] ?? 0;
        $xl  = $inv['XL'] ?? 0;
        $xxl = $inv['XXL'] ?? 0;

        $category = $data['category'] ?? 'General';

       $product->add(
            $data['name'], 
            $data['price'], 
            $data['description'], 
            $imageName, 
            $s, $m, $l, $xl, $xxl,
            $category
           
        );

        return redirect('admin/index');

    }

    public function update($id, $post, $files)
    {
        $product = new Product(getPDO());

        $current = $product->getProductDetails($id);
        $imageName = $current->imageURL; 

        if (!empty($files['image']['name'])) {

            $newImage = uploadImage($files['image'], 'assets');

            if ($newImage) {
                deleteImage('assets', $current->imageURL);
                $imageName = $newImage;
            }
        }

        $inv = $post['inventory'] ?? [];
        $s   = $inv['s'] ?? 0;
        $m   = $inv['m'] ?? 0;
        $l   = $inv['l'] ?? 0;
        $xl  = $inv['xl'] ?? 0;
        $xxl = $inv['xxl'] ?? 0;
        $category = $post['category'] ?? 'General';

       $product->edit(
            $post['id'],
            $post['name'], 
            $post['price'], 
            $post['description'], 
            $category,
            $imageName,
            $s, $m, $l, $xl, $xxl 
        );

        return redirect('admin/index');
    }


}

?>
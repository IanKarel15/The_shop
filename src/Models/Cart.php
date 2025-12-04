<?php

namespace App\Models;
use PDO;


class Cart {

    private $pdo;
    public $product_id;
    public $product_name;
    public $product_size;
    public $product_price;
    public $product_quantity;
    public $product_size_id;

    public function __construct() {
        $this->pdo = getPDO();
    }

    // Añade el producto al carrito con el id, si un producto ya está en el carrito se sumará la cantidad añadida de ese producto al carrito
    public function add($product_id, $size_id, $quantity) {
        $sql = "INSERT INTO cart_clothesitem (cart_id, clothesitem_id, quantity, size_id)
                VALUES (1, :product_id, :quantity, :size_id)
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity;
            ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id,
            'quantity' => $quantity,
            'size_id' => $size_id
        ]);
        $rc = $stmt->rowCount();

        if ($rc) {
            return true; // Productos añadidos (por si se necesita confirmación)
        } else {
            return false; // Fallo al añadir productos
        }
    }

    public function getAll () {
        $sql = 
        "SELECT
                c.id, -- id del producto
                c.name, -- nombre del producto
                c.price, -- precio del producto
                c.image,
                s.id AS size_id, -- id de la talla del producto en el carrito
                s.size, -- nombre de la talla cuya id es la que está en el carrito
                cc.quantity -- catidad del producto en el carrito
            FROM cart_clothesitem cc
            INNER JOIN clothesitem c ON cc.clothesitem_id = c.id
            INNER JOIN size s ON cc.size_id = s.id -- JOIN con la id de la talla en el carrito y la id de la talla en la tabla tallas
            WHERE cc.cart_id = 1; -- **Por ahora es 1 porque el carrito es global
        ";

        $stmt = $this->pdo->prepare($sql);
        // $stmt->execute(['id' => $id]);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene varios productos porque también tiene que conseguir las tallas

        if ($products) {
            $cart_products = [];
            foreach ($products as $p) {
                $cart_product = new Cart ();

                $cart_product->product_id = $p['id'];
                $cart_product->product_name = $p['name'];
                $cart_product->product_price = $p['price'];
                $cart_product->product_size = $p['size'];
                $cart_product->product_size_id = $p['size_id'];
                $cart_product->product_quantity = $p['quantity'];
                $cart_product->product_image = $p['image'];

                $cart_products[] = $cart_product;
            }
            return $cart_products;
        } else {
            return null; // No hay produtos
        }
    }

    // Eliminar producto con la id del producto y la talla a eliminar del producto en el carrito
    public function delete ($product_id, $size_id) {
        $sql = "DELETE FROM cart_clothesitem WHERE clothesitem_id = :product_id AND size_id = :size_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id,
            'size_id' => $size_id
        ]);
        
        if ($stmt->rowCount()){
            return true; // Producto eliminado
        } else {
            return false; // No se pudo eliminar el producto
        }
    }

    public function buyAll () {
        try {
            $this->pdo->beginTransaction();

            //  Descontar stock de la tabla "stock" a los productos y tallas que están en el carrito
            $sqlUpdate = "
                UPDATE stock s
                JOIN cart_clothesitem c
                ON s.clothesitem_id = c.clothesitem_id
                AND s.size_id = c.size_id
                SET s.quantity = GREATEST(s.quantity - c.quantity, 0)
                WHERE c.cart_id = :cart_id
            ";

            $stmtUpdate = $this->pdo->prepare($sqlUpdate);
            $stmtUpdate->execute(['cart_id' => 1]);

            // Vaciar todos los productos del carrito
            $sqlDelete = "
            DELETE FROM cart_clothesitem
            WHERE cart_id = :cart_id
            ";

            $stmtDelete = $this->pdo->prepare($sqlDelete);
            $stmtDelete->execute(['cart_id' => 1]); // Si se agregan carritos a cada usuario se cambiaría el 1 por la id del carrito}

            $this->pdo->commit();
        } catch (Exception $e) {
            $pdo->rollback(); // Error, cancelar consultas
        }
    }

    public function total () {
        $total = 0;
        $sql = "SELECT product.price * cart.quantity AS total FROM clothesitem product
                    JOIN cart_clothesitem cart ON cart.clothesitem_id = product.id
                    JOIN size s ON cart.size_id = s.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $prices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($prices AS $price) {
            $total += $price['total'];
        }

        return $total;
    }

}


// print_r((new Cart())->buyAll());
// print_r(((new Cart())->total()));
//print_r((new Cart())->getAll());

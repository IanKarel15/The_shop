<?php
require_once __DIR__.'/../config/database.php';

class Cart {

    private $pdo;
    public $product_id;
    public $product_name;
    public $product_size;
    public $product_price;
    public $product_quantity;

    public function __construct() {
        $this->pdo = getPDO();
    }

    // Añade el producto al carrito con el id, si un producto ya está en el carrito se sumará la cantidad añadida de ese producto al carrito
    public function add($product_id, $size, $quantity) {
        $sql = "INSERT INTO cart_clothesitem (cart_id, clothesitem_id, quantity)
                VALUES (1, :product_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity;
            ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id,
            'quantity' => $quantity
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
                s.size, -- nombre de la talla cuya id es la que está en el carrito
                cc.quantity -- catidad del producto en el carrito
            FROM cart_clothesitem cc
            INNER JOIN clothesitem c ON cc.clothesitem_id = c.id
            INNER JOIN size s ON cc.size_id = s.id -- JOIN con la id de la talla en el carrito y la id de la talla en la tabla tallas
            WHERE cc.cart_id = 1;; -- **Por ahora es 1 porque el carrito es global
        ";

        $stmt = $this->pdo->prepare($sql);
        // $stmt->execute(['id' => $id]);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene varios productos porque también tiene que conseguir las tallas

        // print_r($products);

        if ($products) {
            $cart_product = new Cart ();
            $cart_products = [];
            foreach ($products as $p) {
                $cart_product->product_id = $p['id'];
                $cart_product->product_name = $p['name'];
                $cart_product->product_price = $p['price'];
                $cart_product->product_size = $p['size'];
                $cart_product->product_quantity = $p['quantity'];

                $cart_products[] = $cart_product;
            }
            return $cart_products;
        } else {
            return null; // No hay produtos
        }
    }

    public function delete ($product_id) {
        $sql = "DELETE FROM clothesitem WHERE id = :id";
        $stmt = $this->pdo->prepdare($sql);
        $stmt->execute(['id' => $product_id]);
        
        if ($stmt->row_count()){
            return true; // Producto eliminado
        } else {
            return false; // No se pudo eliminar el producto
        }
    }

    public function buyAll () {
    }
}


// print_r((new Cart())->getAll());

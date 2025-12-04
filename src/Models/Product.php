<?php
namespace App\Models;
use PDO;
class Product {
    private PDO $pdo;
    public $id;
    public $name;
    public $price;
    public $imageURL;
    public $sizes = [];
    public $description;
    
    public $quantity;
    public $size;

    public function __construct() {
        $this->pdo = getPDO();
    }


    public function getAll() {
        try {
            $sql = "SELECT * FROM clothesitem";
            $stmt = $this->pdo->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];

            foreach($rows as $row) {
                $product = new Product($this->pdo); //Crear objeto de clase Product y después añadir sus atributos
                $product->id = $row['id']; // id
                $product->name = $row['name']; // nombre del produto
                $product->price = $row['price']; // precio del producto
                $product->description = $row['description'];
                $product->imageURL = $row['image'];
                //$product->image = $row['image']; // imagen del producto (pendiente, no lo hemos pensado bien aún)
                $products[] = $product;
            }

            return $products; // Regresa el objeto de clase Product, para acceder a sus atributos con "->(atributo)"
        }catch (PDOException $e) {
            error_log("Error al consultar la base de datoso: ". $e->getMessage());
            return [];
        }
    }

    public function getProductDetails($id) { // Regresar un Producto con id

        if(!is_numeric($id) || $id <= 0) {
            return null;
        }

        try {
            // Por ahora no usamos la imágen
            $sql = "SELECT 
                        ci.id AS clothesitem_id,
                        ci.name AS clothesitem_name,
                        ci.price AS clothesitem_price,
                        s.id AS size_id,
                        s.size AS size_name,
                        ci.description AS clothesitem_description,
                        ci.image AS clothesitem_image,
                        cis.quantity AS quantity
                    FROM clothesitem ci
                    LEFT JOIN stock cis ON ci.id = cis.clothesitem_id
                    LEFT JOIN size s ON cis.size_id = s.id
                    WHERE ci.id = :id;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene varios productos porque también tiene que conseguir las tallas

            if (!$products) {
                return null; // Producto no encontrado
            }
            
            // Guardar todos los datos la primera vez
            $this->id = $products[0]['clothesitem_id'];
            $this->name = $products[0]['clothesitem_name'];
            $this->price = $products[0]['clothesitem_price'];
            $this->description = $products[0]['clothesitem_description'];
            $this->imageURL = $products[0]['clothesitem_image'];
            // $this->image = $products[0]['image'];

            // Guardar todas las tallas disponibles del producto (solo el texto)
           $this->sizes = []; 
        
            foreach ($products as $p) {
            if ($p['size_id'] !== null) {
                $this->sizes[] = (object) [
                    'id'   => $p['size_id'],     
                    'name' => $p['size_name'],   
                    'quantity' => $p['quantity'] 
                ];
            }
        }

            return $this;
        } catch (PDOException $e) {
            error_log("Error al consultar la base de datos: " . $e->getMessage());
            return [];
        }
        
    }

    public function delete($id)
    {
        try {
            // Iniciamos la transacción
            $this->pdo->beginTransaction();

            // Borrar relaciones en el carrito
            $stmtSizes = $this->pdo->prepare("DELETE FROM cart_clothesitem WHERE clothesitem_id = ?");
            $stmtSizes->execute([$id]);

            // // Borrar relaciones en tallas 
            // Ya no se usa la tabla tallas
            // $stmtSizes = $this->pdo->prepare("DELETE FROM clothesitem_size WHERE clothesitem_id = ?");
            // $stmtSizes->execute([$id]);

            // Borrar relaciones en 'stock'
            $stmtStock = $this->pdo->prepare("DELETE FROM stock WHERE clothesitem_id = ?");
            $stmtStock->execute([$id]);

            // Finalmente, borrar el producto padre 'clothesitem'
            $stmtProduct = $this->pdo->prepare("DELETE FROM clothesitem WHERE id = ?");
            $stmtProduct->execute([$id]);

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log("Error al eliminar el producto: " . $e->getMessage());
            return false;
        }
    }

    public function add ($name, $price, $description, $imageURL, $sizeS, $sizeM, $sizeL, $sizeXL, $sizeXXL, $category) {
        $sql = "INSERT INTO clothesitem (name, price, image, description, category) -- Por ahora la categoría es constante
        VALUES (:name, :price, :image, :description, :category)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name, 
            'price' => $price,
            'image' => $imageURL,
            'description' => $description,
            'category' => $category
        ]);

        $lastId = $this->pdo->lastInsertId();

        $sql = 
        "INSERT INTO stock (clothesitem_id, size_id, quantity)
        VALUES
            (:id, 1, :quantity1), 
            (:id, 2, :quantity2),
            (:id, 3, :quantity3),
            (:id, 4, :quantity4),
            (:id, 5, :quantity5)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'quantity1'=>$sizeS,
            'quantity2'=>$sizeM,
            'quantity3'=>$sizeL,
            'quantity4'=>$sizeXL,
            'quantity5'=>$sizeXXL,
            'id'=>$lastId
        ]);
    }

    // Editar producto
    // Se tiene que mandar un arreglo de un arreglo con la id de cada talla del producto y la cantidad de esa talla [['size_id', 'quantity']]
    public function edit ($id, $name, $price, $description, $category, $imageURL, /*$sizes,*/ $size1,$size2,$size3,$size4,$size5) {
        
        // Editar campos básicos del producto
        $sql = 
        "UPDATE clothesitem
            SET
                name = :name,
                price = :price,
                description = :description,
                image = :image,
                category = :category
            WHERE id = :id;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'category' => $category,
            'image' => $imageURL,
            'id' => $id
        ]);

        // Eliminar registros actuales de las tallas del producto
        $sql = 
        "DELETE FROM stock
        WHERE clothesitem_id = :id;";
            
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        // Insertar las tallas y cantidades nuevas
        // $sql = 
        // "INSERT INTO stock (clothesitem_id, size_id, quantity)
        // VALUES
        //     (:product_id, :size_id, :quantity)"; // se repite por la cantidad de tallas disponibles en el sistema
        // $stmt = $this->pdo->prepare($sql);

        // foreach ($sizes as $size){
        //     $stmt->execute([
        //         'product_id' => $id,
        //         'size_id' => $size['size_id'],
        //         'quantity' => $size['quantity']
        //     ]);
        // }

        $sql = 
        "INSERT INTO stock (clothesitem_id, size_id, quantity)
        VALUES
            (:id, 1, :quantity1), 
            (:id, 2, :quantity2),
            (:id, 3, :quantity3),
            (:id, 4, :quantity4),
            (:id, 5, :quantity5)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'quantity1'=>$size1,
            'quantity2'=>$size2,
            'quantity3'=>$size3,
            'quantity4'=>$size4,
            'quantity5'=>$size5,
            'id'=>$id
        ]);
    }

    public function buy($product_id, $size_id) {
        try {
            $this->pdo->beginTransaction();
            $sql = 
            "UPDATE stock s
                JOIN cart_clothesitem cart
                    ON s.clothesitem_id = cart.clothesitem_id
                    AND s.size_id = cart.size_id
                SET s.quantity = GREATEST(s.quantity - cart.quantity, 0)
                WHERE cart.clothesitem_id = :clothesitem_id AND s.size_id = :size_id;";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'clothesitem_id'=>$product_id,
                'size_id'=>$size_id
        ]);

        $this->pdo->commit();
        } catch (Exception $e) {
            $pdo->rollback();
        }
       
    }
    
    public function filterByCategory ($filter) {
        $sql = "SELECT * FROM clothesitem WHERE category = :filter";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['filter'=>$filter]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $productObjects = [];

         foreach($products as $p) {
            $product = new Product($this->pdo); //Crear objeto de clase Product y después añadir sus atributos
            
            $product->id = $p['id']; // id
            $product->name = $p['name']; // nombre del produto
            $product->price = $p['price']; // precio del producto
            $product->description = $p['description'];
            $product->imageURL = $p['image'];

            $productObjects[] = $product;
        }

            return $productObjects;
    }

    public function search ($filter)  {
        $sql = "SELECT * FROM clothesitem WHERE name LIKE :filter";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['filter'=>"%".$filter."%"]);
        $productObjects = [];

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($products as $p) {
            $product = new Product($this->pdo); //Crear objeto de clase Product y después añadir sus atributos
            
            $product->id = $p['id']; // id
            $product->name = $p['name']; // nombre del produto
            $product->price = $p['price']; // precio del producto
            $product->description = $p['description'];
            $product->imageURL = $p['image'];

            $productObjects[] = $product;
        }
        return $productObjects;

    }

}
// print_r((new Product())->getProductDetails(4));
// $name, $price, $description, $imageURL, $sizeS, $sizeM, $sizeL, $sizeXL, $sizeXXL, $category
// (new Product())->add("Camisa de prueba", 199, "Prueba de producto", "img2.png", 1, 1, 0, 1, 1, 'shirt');
// print_r((new Product())->getAll());
// ((new Product())->buy(2,1));

// ((new Product())->edit(2, "nombre edit", 9999999, "descripcion edit", "img2.png", 
// [
//     [
//         'size_id'=>1,
//         'quantity'=>1
//     ],
//     [
//         'size_id'=>2,
//         'quantity'=>666
//     ]
// ]));

// print_r(((new Product())->delete(2)));
// print_r(((new Product())->filterByCategory("shirts")));
// print_r(((new Product())->search("s")));
    // public function edit ($id, $name, $price, $description, $category, $imageURL, $size1,$size2,$size3,$size4,$size5) {

?>
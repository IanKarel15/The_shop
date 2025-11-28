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
                        ci.image AS clothesitem_image
                    FROM clothesitem ci
                    LEFT JOIN clothesitem_size cis ON ci.id = cis.clothesitem_id
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
            foreach ($products as $p) {
                $this->sizes[] = $p['size_name'];
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

            // Borrar relaciones en 'clothesitem_size' 
            $stmtSizes = $this->pdo->prepare("DELETE FROM clothesitem_size WHERE clothesitem_id = ?");
            $stmtSizes->execute([$id]);

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

    public function add ($name, $price) {
        $sql = "INSERT INTO clothesitem (name, price)
        VALUES (:name, :price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'price' => $price]);
    }

    public function edit ($id, $name, $price) {
        $sql = 
        "UPDATE clothesitem 
            SET 
                name = :name,
                price = :price
            WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'id' => $id
        ]);
    }
}
// print_r((new Product())->getProductDetails(2));

?>
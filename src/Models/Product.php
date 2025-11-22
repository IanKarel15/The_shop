<?php
require_once __DIR__.'/../config/database.php';

class Product {
    private PDO $pdo;
    public $id;
    public $name;
    public $price;
    public $image;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
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

/*    public function find($id) {

        if(!is_numeric($id) || $id <= 0) {
            return null;
        }

        try {
            $sql = "SELECT * FROM careers WHERE id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $careerDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$careerDetails) {
                return null; // Carrera no encontrada
            }

            $this->id = $careerDetails['id'];
            $this->name = $careerDetails['name'];
            $this->description = $careerDetails['description'];
            $this->image = $careerDetails['image'];

            return $this;
        } catch (PDOException $e) {
            error_log("Error al consultar la base de datos: " . $e->getMessage());
            return [];
        }
    }
        */
}
?>
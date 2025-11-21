<?php

class Product {
    private PDO $pdo;
    public $id;
    public $name;
    public $description;
    public $image;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        try {
            $sql = "SELECT * FROM careers";

            $stmt = $this->pdo->query($sql);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];

            foreach($rows as $row) {
                $product = new Product($this->pdo);
                $product->id = $row['id'];
                $product->name = $row['name'];
                $product->description = $row['description'];
                $product->image = $row['image'];
                $products[] = $product;
            }

            return $products;
        }catch (PDOException $e) {
            error_log("Error al consultar la base de datoso: ". $e->getMessage());
            return [];
        }
    }

    public function find($id) {

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
}
?>
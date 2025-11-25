<?php
require_once __DIR__.'/../config/database.php';

class User {
    private $pdo;

    public function __construct(Type $var = null) {
        $this->pdo = getPDO();
    }

    public function login ($username, $password){
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user['type']; // Login exitoso, regresa el tipo de usuario ('user' o 'admin')
            } else {
                return null; // Login falló
            }

    }

}

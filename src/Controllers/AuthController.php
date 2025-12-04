<?php 

namespace App\Controllers;
require_once __DIR__ . '/../helpers/functions.php';

use PDO;

class AuthController {
    public function findUserByUsername($username)
    {
        $stmt = getPDO()->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function attemptLogin($username, $password)
    {
        $user = $this->findUserByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return view('auth/login', ['error' => 'Credenciales incorrectas']);
        }
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_type'] = $user['type'];
        
        redirect('home');
    }

    public function logout()
    {
        session_start();

        
        $_SESSION = [];

       
        session_destroy();

        
        redirect('home');
    }
}
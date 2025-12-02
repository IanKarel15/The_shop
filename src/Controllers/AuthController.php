<?php 

namespace App\Controllers;

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

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];

        if($user["type"]==="admin"){
             redirect('admin/index');
        }
        else
            redirect('home');
    }

    public function logout()
    {
        session_start();

        
        $_SESSION = [];

       
        session_destroy();

        
        redirect('login');
    }
}
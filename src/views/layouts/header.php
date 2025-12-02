<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Shop</title>
    <link rel="icon" type="image/png" href="<?=ASSETS_PATH?>/icono.png">
    <link href="https://fonts.google.com/specimen/Julius+Sans+One" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASE_PATH?>/css/style.css">
    </head>
<body>

    <header>
        <div class="top-bar">
            <div class="logo-container">
                <a href="<?=BASE_PATH?>/home">
                    <img class="logo" src="<?=ASSETS_PATH?>/logo.png" alt="The Shop Logo">
                </a>
            </div>
            
            <div class="auth-links">
                <?php if(isAuthenticated()): ?>
                    <li><a class="auth-link" href="<?=BASE_PATH?>/logout">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a class="auth-link" href="<?=BASE_PATH?>/login">Iniciar sesión</a></li>
                <?php endif; ?>
            </div>
        </div>

        
   
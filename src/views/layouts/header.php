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
                <img class="logo" src="<?=ASSETS_PATH?>/logo.png" alt="The Shop Logo">
            </div>
            
            <div class="auth-links">
                <a class="link-auth" href="registro.html">REGISTRAR</a>
                <a class="btn-login" href="login.html">INICIAR SESION</a>
            </div>
        </div>

        <div class="bottom-bar">
            <nav class="menu-categorias">
                <a class="link-cat" href="#">CAMISAS</a>
                <a class="link-cat" href="#">PANTALONES</a>
                <a class="link-cat" href="#">ACCESORIOS</a>
            </nav>

            <div class="iconos-container">
                <a href="buscar.html"><img src="<?=ASSETS_PATH?>/lupa.png" alt="Buscar"></a>
                <a href="perfil.html"><img src="<?=ASSETS_PATH?>/perfil.png" alt="Perfil"></a>
                <a href="carrito.html"><img class="icono-carrito" src="<?=ASSETS_PATH?>/carrito.png" alt="Carrito"></a>
            </div>
        </div>
    </header>

   
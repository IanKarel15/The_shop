<?php 
require_once '../src/views/layouts/header.php';
?>

<div class="bottom-bar">
            <nav class="menu-categorias">
                <a class="link-cat" href="#"></a>
                <a class="link-cat" href="#"></a>
                <a class="link-cat" href="#"></a>
            </nav>

            <div class="iconos-container">
                <a href="buscar.html"><img src="<?=ASSETS_PATH?>/lupa.png" alt="Buscar"></a>
                <a href="perfil.html"><img src="<?=ASSETS_PATH?>/perfil.png" alt="Perfil"></a>
                <a href="carrito.html"><img class="icono-carrito" src="<?=ASSETS_PATH?>/carrito.png" alt="Carrito"></a>
            </div>
        </div>
    </header>


<main class="detalle-producto-container">
    
    <div class="columna-imagen">
        <img src="<?=ASSETS_PATH?>/img1.png" alt="<?= htmlspecialchars($product->name ?? 'Producto sin nombre') ?>">
    </div>

    <div class="columna-info">
        <h1 class="titulo-producto"><?= htmlspecialchars($product->name ?? 'Producto sin nombre') ?></h1>
        <p class="precio-producto"><?= htmlspecialchars($product->price ?? 'Producto sin precio') ?></p>
        <p class=""><?= htmlspecialchars($product->description ?? 'Producto sin descripcion') ?></p>

        <div class="seccion-tallas">
            <span class="label-tallas">TALLAS</span>
            <div class="opciones-tallas">
                <a href="#" class="talla">S</a>
                <a href="#" class="talla">M</a>
                <a href="#" class="talla">L</a>
                <a href="#" class="talla">XL</a>
                <a href="#" class="talla">XXL</a>
            </div>
        </div>

        <button class="btn-agregar-carrito">AGREGAR</button>
    </div>

</main>
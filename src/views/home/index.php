<?php 
    require_once '../src/views/layouts/header.php';
?>
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

<main class="producto-content">
    <?php 
    if (!empty($products) && is_array($products)) : 
        foreach($products as $product) : 
    ?>
    <div class="producto">
        <a href="<?=BASE_PATH?>/products/<?=$product->id?>">
            <img src="<?=ASSETS_PATH?>/img1.png" alt="<?= htmlspecialchars($product->name ?? 'Producto') ?>">
        </a>
        <h3><?= htmlspecialchars($product->name ?? 'Producto sin nombre') ?></h3>
        <h2><?= htmlspecialchars($product->price ?? 'Producto sin precio') ?></h3>
    </div>
    <?php endforeach; ?> 
    <?php else : ?>
        <p class="no-products-message">No se encontraron productos disponibles en esta categoría.</p>
    <?php endif; ?>
</main>
        
</body>
</html>
<?php 
    require_once '../src/views/layouts/header.php';
?>
<div class="bottom-bar">
            <nav class="menu-categorias">
                <a class="link-cat" href="camisas">CAMISAS</a>
                <a class="link-cat" href="pantalones">PANTALONES</a>
                <a class="link-cat" href="accesorios">ACCESORIOS</a>
            </nav>

           <form id="search-form" action="?route=search" method="POST">
                <div class="search-bar-container">
                    <input type="text" class="search-bar" id="search-bar" name="q" placeholder="Buscar">
                    <a href="#" id="search-button">
                        <img src="<?=ASSETS_PATH?>/lupa.png" alt="Buscar">
                    </a>
                </div>
            </form>

            <script>
            document.getElementById("search-button").addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById("search-form").submit();
            });
            </script>

            <div class="iconos-container">
                <?=strtoupper($_SESSION['user_name'] ?? "")?>
                <a href="perfil.html"><img src="<?=ASSETS_PATH?>/perfil.png" alt="Perfil"></a>
                <a href="<?=BASE_PATH?>/carrito"><img class="icono-carrito" src="<?=ASSETS_PATH?>/carrito.png" alt="Carrito"></a>
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
            <div class="image-wrapper"> 
                <img src="<?=ASSETS_PATH?>/<?= htmlspecialchars($product->imageURL ?? 'Producto sin imagen') ?>" alt="<?= htmlspecialchars($product->name ?? 'Producto') ?>">
            </div>
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
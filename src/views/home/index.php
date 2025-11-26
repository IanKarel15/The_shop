<?php 
require_once '../src/views/layouts/header.php';
?>

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
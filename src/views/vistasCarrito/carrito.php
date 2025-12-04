<?php 
    require_once '../src/views/layouts/header.php';
?>

<main class="cart-container">
    
    <div class="cart-title-section">
        <h2>PRODUCTOS</h2>
        <div class="thick-divider"></div>
    </div>

    <div class="cart-items-list">
        
        <?php if (!empty($products)): ?> 
            <?php foreach ($products as $item): ?>
            
            <div class="cart-item-row">
            
                <div class="cart-img-wrapper">
                    
                    <img src="<?=ASSETS_PATH?>/<?= $item->imageURL ?? 'placeholder.png' ?>" alt="Producto">
                </div>

               
                <div class="cart-info">
                    <h3 class="product-name"><?= $item->name ?? 'NOMBRE DEL PRODUCTO' ?></h3>
                   
                    <a href="<?=BASE_PATH?>/cart/remove/<?= $item->id ?>" class="link-remove">ELIMINAR</a>
                </div>

                
                <div class="cart-price">
                    $<?= number_format($item->price, 2) ?>
                </div>
            </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-cart-msg">Tu carrito está vacío.</p>
        <?php endif; ?>

    </div>

    <!-- Sección de Total -->
    <div class="cart-total-section">
        <div class="thick-divider"></div> <!-- Línea gruesa divisoria -->
        <div class="total-row">
            <span class="label-total">TOTAL</span>
            <span class="amount-total">$<?= number_format($total ?? 0, 2) ?></span>
        </div>
    </div>

    <!-- Botón Comprar -->
    <div class="cart-actions">
        <a href="<?=BASE_PATH?>/checkout" class="btn-checkout">
            COMPRAR
        </a>
    </div>

</main>

</body>
</html>
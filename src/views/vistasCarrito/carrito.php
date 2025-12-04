<?php 
    require_once 'src/views/layouts/header.php';
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
                    
                    <img src="<?=ASSETS_PATH?>/<?= $item->product_image ?? 'placeholder.png' ?>" alt="Producto">
                </div>

               
                <div class="cart-info">
                    <h3 class="product-name"><?= $item->product_name ?? 'NOMBRE DEL PRODUCTO' ?></h3>
                   
                    <a onclick="eliminar(event)" href="<?=BASE_PATH?>/carrito/delete/<?= $item->product_id ?>/<?= $item->product_size_id ?>" class="link-remove">
                        ELIMINAR
                    </a>
                </div>

                <div class="price-group">
                    <div class="cart-price">
                        $<?= number_format($item->product_price, 2) ?>
                    </div>

                    <div class="cart-cantidad">
                        <?= $item->product_quantity ?>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-cart-msg">Tu carrito está vacío.</p>
        <?php endif; ?>

    </div>

    <div class="cart-total-section">
        <div class="thick-divider"></div> 
        <div class="total-row">
            <span class="label-total">TOTAL</span>
            <span class="amount-total">$<?= number_format($total ?? 0, 2) ?></span>
        </div>
    </div>

    <?php if (($total ?? 0) > 0): ?> 
        <div class="cart-actions">
            <a href="<?=BASE_PATH?>/buy" class="btn-checkout">
                COMPRAR
            </a>
        </div>
    <?php endif; ?>

</main>

</body>
</html>

<script>
    function eliminar(event){
        event.preventDefault(); 
        const deleteUrl = event.currentTarget.href; 
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡Esto eliminara todos los productos!",
            icon: "warning",
            showCancelButton: true,
            
            
            reverseButtons: true, 
            confirmButtonColor: "rgba(0, 108, 209, 1)", 
            cancelButtonColor: "#e90000ff", 
            confirmButtonText: "Sí, ¡Bórralo!",
            cancelButtonText: "Cancelar"
            
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl; 
            }
        });
    }
</script>

<?php 
require_once '../src/views/layouts/header.php';
?>

<div class="bottom-bar">
            <nav class="menu-categorias">
                <a class="link-cat" href="#"></a>
                <a class="link-cat" href="#"></a>
            </nav>

            <div class="iconos-container">
                <a href="perfil.html"><img src="<?=ASSETS_PATH?>/perfil.png" alt="Perfil"></a>
                <a href="<?=BASE_PATH?>/carrito"><img class="icono-carrito"><img class="icono-carrito" src="<?=ASSETS_PATH?>/carrito.png" alt="Carrito"></a>
            </div>
        </div>
    </header>


<main class="detalle-producto-container">
    
    <div class="columna-imagen">
        <img src="<?=ASSETS_PATH?>/<?= htmlspecialchars($product->imageURL ?? 'Producto sin imagen') ?>" alt="<?= htmlspecialchars($product->name ?? 'Producto sin nombre') ?>">
    </div>
    <form action="<?=BASE_PATH?>/carrito/add" method="POST" enctype="multipart/form-data">
        <?php if ($product): ?>
            <input type="hidden" name="id" value="<?= $product->id ?>">
            <input type="hidden" name="size_id" id="selectedSizeId" value="">
            <input type="hidden" name="quantity" value="1">
        <?php endif; ?> 
        
        <div class="columna-info1">
            <h1 class="titulo-producto"><?= htmlspecialchars($product->name ?? 'Producto sin nombre') ?></h1>
            <p class="precio-producto"><?= htmlspecialchars($product->price ?? 'Producto sin precio') ?></p>

            <div class="seccion-tallas1">
                <p class="descripcion-producto1"><?= htmlspecialchars($product->description ?? 'Producto sin descripcion') ?></p>
                <span class="label-tallas1">TALLAS</span>
            
            <div class="opciones-tallas1">
                    <?php if (!empty($product->sizes)): ?>
                        <?php foreach ($product->sizes as $size): ?>
                            <?php if ($size->quantity > 0): ?>
                                <button type="button" class="talla-item1" data-id="<?= $size->id ?>">
                                    <?= htmlspecialchars($size->name ?? $size->size) ?>
                                </button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="error-text">No hay tallas disponibles</p>
                    <?php endif; ?>
                </div>

            
            
            <button type="submit" name="action" value="add_only" class="btn-agregar-carrito btn-disabled" id="btn-agregar" disabled>
                AGREGAR AL CARRITO
            </button>
        </div>
    </form>
</main>


<script>
    //esto es para que cuando se seleccione una talla de desabiliten las demas y se habilite el boton de agregar
document.addEventListener('DOMContentLoaded', function() {
    const botonesTalla = document.querySelectorAll('.talla-item1');
    const inputSizeId = document.getElementById('selectedSizeId');
    const btnAgregar = document.getElementById('btn-agregar');

    botonesTalla.forEach(boton => {
        boton.addEventListener('click', function() {
            
            botonesTalla.forEach(b => b.classList.remove('selected'));

            this.classList.add('selected');
           
            inputSizeId.value = this.dataset.id;

            btnAgregar.disabled = false;
    
            btnAgregar.classList.remove('btn-disabled');
        });
    });
});
</script>
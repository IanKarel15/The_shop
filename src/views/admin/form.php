<?php 
    require_once '../src/views/layouts/header.php';
?>


<main class="detalle-producto-container">

    <?= $product ? 'Editar producto' : 'Nuevo producto' ?>
    <form action="<?=BASE_PATH?>/admin/products<?= $product ? '/edit/'.$product->id : '/create'?>" method="post" enctype="multipart/form-data">
        <?php if ($product): ?>
            <input type="hidden" name="id" value="<?= $product->id ?>">
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?> 

        <input type="file" name="image" accept="image/*" class="columna-imagen">

            <?php if (!empty($product->image)): ?>
                <p class="">Imagen actual:</p>
                <img src="<?=ASSETS_PATH?>/<?= $product->image ?>">
            <?php endif; ?>

        <div class="columna-info">
            <input type="text" name="name" required value="<?= $product->name ?? '' ?>" class="">
            <input type="number" name="price" required value="<?= $product->price ?? '' ?>" class="">
            <textarea name="description" required class=""><?= $product->description ?? '' ?></textarea>
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

            <button type="submit">
                <?= $product ? 'Actualizar' : 'Guardar' ?>
            </button>
        </div>
    </form>
</main>

    

<?php 
    require_once '../src/views/layouts/header.php';
?>


<main class="detalle-producto-container">
    <h2 class="subtitulo-form">
        <?= $product ? 'Editar producto' : 'Nuevo producto' ?>
    </h2>
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
                    <?php 
                        $tallas_inventario = ['S', 'M', 'L', 'XL', 'XXL'];
                        
                        $invData = [];
                        if ($product && !empty($product->sizes)) {
                            foreach ($product->sizes as $sObj) {
                                $invData[$sObj->name] = $sObj->quantity;
                            }
                        }

                        foreach ($tallas_inventario as $talla_clave) : 
                            $valor_actual = $invData[$talla_clave] ?? 0;
                            $talla_id = strtolower($talla_clave); 
                        ?>
                        <div class="talla-inventario-group">
                            <label for="talla-<?= $talla_id ?>" class="talla-label"><?= $talla_clave ?></label>
                            <input 
                                type="number" 
                                id="talla-<?= $talla_id ?>" 
                                name="inventory[<?= $talla_clave ?>]" 
                                value="<?= $valor_actual ?>"
                                min="0" max="999" maxlength="3"           
                                class="input-inventario"
                            >
                        </div>
                        <?php endforeach; ?>
                </div>
            </div>

            <button type="submit">
                <?= $product ? 'Actualizar' : 'Guardar' ?>
            </button>
        </div>
    </form>
</main>

    

<?php 
    require_once 'src/views/layouts/header.php';
?>

<h2 class="subtitulo-form">
    <?= $product ? 'Editar producto' : 'Nuevo producto' ?>
</h2>
<main class="detalle-producto-container">

    <form action="<?=BASE_PATH?>/admin/products<?= $product ? '/edit/'.$product->id : '/create'?>" method="post" enctype="multipart/form-data">
        <?php if ($product): ?>
            <input type="hidden" name="id" value="<?= $product->id ?>">
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?> 
        
        <div class="columna-imagen">
            <input type="file" name="image" accept="image/*" class="columna-imagen">

                <?php if (!empty($product->imageURL)): ?>
                    <p class="">Imagen actual:</p>
                    <img src="<?=ASSETS_PATH?>/<?= htmlspecialchars($product->imageURL ?? 'Producto sin imagen') ?>">
                <?php endif; ?>
        </div>

        <div class="columna-info">
            <input placeholder ="Ingresa el nombre" type="text" name="name" required value="<?= $product->name ?? '' ?>" class="">
            <input placeholder ="Ingresa el precio" type="number" name="price" required value="<?= $product->price ?? '' ?>" class="">
            <textarea placeholder ="Ingresa la descripcion.." name="description" required class=""><?= $product->description ?? '' ?></textarea>
            <div class="form-group">
                <label for="category" class="label-form">CATEGORÍA</label>
                <select name="category" id="category" class="input-select" required>
                    <option value="" disabled <?= empty($product->category) ? 'selected' : '' ?>>Selecciona una categoría</option>
                    
                    <option value="shirts" <?= ($product && isset($product->category) && $product->category === 'shirts') ? 'selected' : '' ?>>
                        CAMISAS
                    </option>
                    
                    <option value="pants" <?= ($product && isset($product->category) && $product->category === 'pants') ? 'selected' : '' ?>>
                        PANTALONES
                    </option>
                    
                    <option value="accesories" <?= ($product && isset($product->category) && $product->category === 'accesories') ? 'selected' : '' ?>>
                        ACCESORIOS 
                    </option>
                </select>
            </div>
            <div class="seccion-tallas">
                <span class="label-tallas">TALLAS</span>
                <div class="opciones-tallas">
                    <?php 
                        $tallas_inventario = ['s', 'm', 'l', 'xl', 'xxl'];
                        
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

    

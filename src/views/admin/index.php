<?php 
    require_once '../src/views/layouts/header.php';
?>
<main class="main-content">
    
    <h2 class="page-title">Listado de Productos</h2>

    <a href="<?=BASE_PATH?>/admin/products/create" class="btn-main">
        Nuevo Producto
    </a>

    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th> <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product->name ?></td>
                    <td><?= $product->description ?></td>
                    <td>$<?= $product->price ?></td> <td class="actions-cell">
                        <a href="<?=BASE_PATH?>/admin/products/edit/<?= $product->id ?>" class="btn-action btn-edit">
                            Editar
                        </a>

                        <a href="<?=BASE_PATH?>/admin/products/delete/<?= $product->id ?>"
                           onclick="return confirm('¿Eliminar este producto?')"
                           class="btn-action btn-delete">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>
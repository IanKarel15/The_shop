<?php 
    require_once '../src/views/layouts/header.php';
?>

<main class="error-page-container">
    <div class="error-content">
        <h1 class="codigo-404">404</h1>
        <h2 class="mensaje-titulo">PÁGINA NO ENCONTRADA</h2>
        <p class="mensaje-texto">
            Lo sentimos, la página o el producto que buscas no existe o ha sido movido de nuestro inventario.
        </p>
        
        <a href="<?=BASE_PATH?>" class="btn-volver">
            VOLVER AL INICIO
        </a>
    </div>
</main>
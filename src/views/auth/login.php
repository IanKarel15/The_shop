<?php 
    require_once '../src/views/layouts/header.php';
?>

        <main>

            <?php if (isset($error)): ?>
                <p><?= $error ?></p>
            <?php endif; ?>
            <form method="post"  action="<?=BASE_PATH?>/login">
                <div>
                    <label>Nombre de usuario</label>
                    <input type="text" name="username" required>
                </div>

                <div>
                    <label>Contraseña</label>
                    <input type="password" name="password" required>
                </div>

            <button type="submit">
                Iniciar sesion
            </button>
            </form>
        </main>


</body>
</html>
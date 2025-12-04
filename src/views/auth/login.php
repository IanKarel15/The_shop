<?php 
    require_once 'src/views/layouts/header.php';
?>

        <main class="login-container">
    
            <div class="login-header">
                <h2>INICIAR SESION</h2>
            </div>

            <?php if (isset($error)): ?>
                <p class="error-msg"><?= $error ?></p>
            <?php endif; ?>

            <form method="POST" action="<?=BASE_PATH?>/login" class="login-form">
                
                <div class="input-group">
                    <input type="text" name="username" class="styled-input" placeholder="NOMBRE DE USUARIO" required>
                </div>

                <div class="input-group">
                    <input type="password" name="password" class="styled-input" placeholder="CONTRASEÑA" required>
                </div>

                <button type="submit" class="styled-btn">
                    INICIAR SESION
                </button>
            </form>
        </main>


</body>
</html>
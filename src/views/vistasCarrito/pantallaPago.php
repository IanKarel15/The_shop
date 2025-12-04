<?php 
require_once '../src/views/layouts/header.php';
?>

<main class="payment-container">
    
    <h1>AGREGAR UNA TARJETA</h1>
    
    <form action="<?=BASE_PATH?>/checkout" method="POST"> 
        
        <div class="payment-form-group">
            <h2>NÚMERO DE TARJETA</h2>
            <input type="number" name="card_number" placeholder="" minlength="16" maxlength="16" required>
        </div>
        
        <div class="payment-form-group">
            <h2>NOMBRE DEL TITULAR</h2>
            <input type="text" name="card_name" placeholder="" required>
        </div>
        
        <div class="payment-form-group cvv-cvv-group">
            <div class="cvv-input-wrapper">
                <h2>CVV</h2>
                <input type="number" name="cvv" min="100" max="999" maxlength="3" class="cvv-input" required>
            </div>
        </div>

        <button type="submit" class="btn-comprar-ya">
            COMPRAR YA
        </button>
    </form>

</main>

<?php if (isset($success) && $success): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "¡Compra Exitosa!",
                text: "Tu pedido ha sido procesado. Redirigiendo...",
                icon: "success",
                showConfirmButton: false,
                timer: 2000, 
            }).then(() => {
                
                window.location.href = '<?=BASE_PATH?>/home';
            });
        });
    </script>
<?php endif; ?>
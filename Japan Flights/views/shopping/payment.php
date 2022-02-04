<section class="container">
    <h1 class="orderId" data-order="<?= htmlspecialchars($_GET['orderNum']) ?>">Payment of order No. <?= htmlspecialchars($_GET['orderNum']) ?></h1>
    
    <p data-amount="<?= $totalAmount ?>">Total amount due: $<?= (number_format($totalAmount, 2)) ?></p>
</section>
    
<section class="container">
    <h2>Payment form</h2>
    
    <!-- Payment form -->
    <form id="payment-form">
        
        <!-- Div to display error messages via the Stripe API -->
        <div class="errors"></div>
        
        <input type="text" class="cardholder-name" placeholder="Full name of the card holder" value="<?= htmlspecialchars(trim($_SESSION['user']['first_name'])) ?> <?= htmlspecialchars(trim($_SESSION['user']['last_name'])) ?>">
        
        <!-- Div to display the payment form created via the Stripe API -->
        <div class="form-payment"></div>
        
        <div>
            <button class="card-button" type="button" data-secret="<?= $intent['client_secret'] ?>">Proceed to payment</button>
        </div>
    </form>
</section>
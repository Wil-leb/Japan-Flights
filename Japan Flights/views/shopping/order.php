<section class="container">
    <h1 class="order-id" data-order="<?= htmlspecialchars($_GET['orderId']) ?>">Order No. <?= htmlspecialchars($_GET['orderId']) ?></h1>
    
    <p class="user-id" data-user-id="<?= htmlspecialchars($_SESSION['user']['id']) ?>"><?= 'Hello' . ',' . ' ' . htmlspecialchars($_SESSION['user']['login']) ?></p>
    
    <div class="order-cart">

        <!-- Div to display a filled cart -->
        <div class="filled-cart">
            <table>
	    		<thead>
	                <tr>
	                    <th>Article</th>
	                    <th>Unit price</th>
	                    <th>Quantity</th>
	                    <th>Total price</th>
	                </tr>
	    		</thead>
            
                <tbody class="cart-tbody"></tbody>
    	    </table>
    	    
    	    <div class="amount">
    	        <!-- Paragraph to display a cart's total amount via JavaScript -->
	    	    <p class="total-amount"></p>
            </div>
            <p>Go to the <a href="index.php?p=payment" class="confirm-order">Payment page</a></p>
        </div>
        
    </div>
</section>
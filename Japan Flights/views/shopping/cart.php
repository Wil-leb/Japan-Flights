<section class="container">
    <h1>Your shopping cart</h1>
    
    <div class="shopping-cart">
        <!-- Div to display a message and a link via JavaScript, if a cart is empty -->
        <div class="empty-cart"></div>

        <!-- Div to display a filled cart -->
        <div class="filled-cart">
            <table>
	    		<thead>
	                <tr>
	                    <th>Article</th>
	                    <th>Unit price</th>
	                    <th>Quantity</th>
	                    <th>Total price</th>
	                    <!-- Link to delete an article with a JavaScript event -->
	                    <th class="delete-article">Deletion</th>
	                </tr>
	    		</thead>
            
                <!-- Table body to display a filled cart's content via JavaScript -->
                <tbody class="cart-tbody"></tbody>
    	    </table>
    	    
    	    <div class="amount">
    	        <!-- Paragraph to display a cart's total amount via JavaScript -->
                <p class="total-amount"></p>
                
                <a href="index.php?p=destinations">Continue shopping</a>
            </div>
            
            <!-- Asking a user to connect, in order to validate a cart -->
            <?php if(!$session::online()) : ?>
            <p>Please <a href="index.php?p=login">log in</a> in order to validate your shopping cart.</p>
            
            <!-- Allowing a connected user to validate a cart -->
            <?php else : ?>
            <a href="index.php?p=toPayment">Validate cart</a>
            <?php endif;?>
            
            <!-- Button to empty a cart with a JavaScript event -->
            <button type="button" class="clear-cart">Empty cart</button>
        </div>
        
    </div>
</section>
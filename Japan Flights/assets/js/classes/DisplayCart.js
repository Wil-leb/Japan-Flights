import Cart from './Cart.js';

export default class DisplayCart {
    
//*****GOALS: TO DISPLAY A FILLED CART IF IT HAS CONTENT,
//*****TO DISPLAY AN EMPTY CART IF IT HAS NO CONTENT,
//*****AND TO DISPLAY THE TOTAL AMOUNT OF A FILLED CART//

//*****METHODS: FIND THE CART'S CONTENT VIA THE Cart CLASS,
//*****TO DISPLAY A FILLED CART IF THE USER IS IN THE ORDER PAGE,
//*****TO DISPLAY A FILLED CART OR AN EMPTY CART IF THE USER IS IN THE CART PAGE,
//*****AND TO CREATE HTML TAGS IN WHICH TO DISPLAY A FILLED CART'S CONTENT******//
    
    constructor(page = 'cart') {
        this.cart = new Cart();
        this.shopCart = this.cart.loadCart();
        this.emptyCart = document.querySelector('.empty-cart');
        this.filledCart = document.querySelector('.filled-cart');
        this.check(page);
    }
    
//*****1. Checking in which page is a user*****//
    check(page) {
        
//*****A. If a user is in the Order page*****//
        if(page == 'order') {
            
//*****i. Hiding the cart logo*****//
            document.querySelector('.shop').style.display = 'none';
            
//*****ii. Displaying a filled cart*****//
            this.displayCart('order');
            return;
        }
        
//*****B. If a user is in the Cart page*****//
        else {
            
//*****i. Hiding an empty cart and displaying a filled one*****//
            this.emptyCart.style.display = 'none';
            this.displayCart('cart');

//*****ii. If a cart is empty*****//
            const shopCart = this.shopCart;

            if(shopCart.length == 0) {
                this.displayEmptyCart(); 
            }

//*****END OF THE ELSE CONDITION*****//
        }
        
//*****END OF THE Check() FUNCTION*****//
    }
    
//*****2. Function to allow the creation of tags*****//
    createTag(tagHtml, content = null) {
        const tag = document.createElement(tagHtml);
        tag.textContent = content;
        return tag;
    }
    
//*****3a. Displaying a filled cart*****//
    displayCart(page) {
        this.filledCart.style.display = 'block';
        
//*****A. Allowing a cart's content to reload, before being updated*****//
        document.querySelector('.cart-tbody').innerHTML = '';
        
//*****B. Looping on a loaded cart*****//
        for(const item of this.shopCart) {
            
//*****i. Creating <tr> and <td>, in which to display a cart's content*****//
            const tr = this.createTag('tr');
            const tdName = this.createTag('td', item.name);
            const tdPrice = this.createTag('td', item.price.toFixed(2));
            const tdQuantity = this.createTag('td', item.quantity);
            const tdAmount = this.createTag('td', (item.price*item.quantity).toFixed(2));
            
//*****ii. Setting attributes to the created <td>, so as to be able to make a responsive table*****//
            tdName.setAttribute('data-label', 'Article');
            tdPrice.setAttribute('data-label', 'Unit price');
            tdQuantity.setAttribute('data-label', 'Quantity');
            tdAmount.setAttribute('data-label', 'Total price');
            
//*****iii. Appending the created <td> in the created <tr>*****//
            tr.append(tdName, tdPrice, tdQuantity, tdAmount);
            
//*****iv. Creating <td> and <a> in a selected <tr>, to allow for an article's deletion*****//
            if(document.querySelector('.delete-article')) {
                const tdDelete = this.createTag('td');
                const hyperText = this.createTag('a', 'Delete article');

//*****v. Setting a value and a dataset to the created <a>*****//
                hyperText.href = '#';
                hyperText.dataset.deleteId = item.id;
                
//*****v. Appending the created <a> in the created <td>*****//
                tdDelete.append(hyperText);
                tdDelete.setAttribute('data-label', 'Deletion');

//*****vii. Appending the created <td> to the selected <tr>*****//
                tr.append(tdDelete);
                
//*****END OF THE IF CONDITION*****//
            }
            
            document.querySelector('.cart-tbody').prepend(tr);
            
//*****END OF THE FOR LOOP*****//
        }
        
        this.displayAmount();
        
//*****END OF THE displayCart() FUNCTION*****//
    }
    
//*****3b. Displaying an empty cart*****//

    displayEmptyCart() {
//*****A. Displaying an empty cart and hiding a filled one*****//
        this.emptyCart.style.display = 'block';
        this.filledCart.style.display = 'none';
        
//*****B. Fixing the content of selected paragraphs in an empty cart*****//
        this.emptyCart.innerHTML = `<p>Your cart is currently empty.</p> <p>Go to the <a href="index.php?p=destinations">Destinations page</a></p>`;
        this.emptyCart.style.textAlign = 'center';
    }
    
//*****4. Displaying the total amount of a filled cart*****//
    displayAmount() {
        const shoppingCart = this.shopCart;
        
//*****A. Fixing the total amount to 0 by default*****//
        let totalAmount = 0.0;
        
        
//*****B. Fixing the total amount of each article with a loop*****//
        for(const item of shoppingCart) {
            totalAmount += item.price * item.quantity;
        }
        
//*****C. Displaying a cart's total amount in a selected paragraph, and styling the content*****//
        document.querySelector('.total-amount').innerHTML = `The total amount of the order is
                                                                $${totalAmount.toFixed(2)}.`;
        document.querySelector('.total-amount').style.fontWeight = '900';
    }
    
//*****END OF THE DisplayCart CLASS*****//
}
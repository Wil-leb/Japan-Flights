import Cart from './Cart.js';
import Modal from './Modal.js';
import DisplayCart from './DisplayCart.js';

//*****GOALS: TO UPDATE THE CART WHEN AN ARTICLE IS ADDED OR DELETED, AND TO DISPLAY A TOTAL AMOUNT IN
//THE CART'S LOGO***********************************************************************************//

//*****METHODS: TO FIND AN ARTICLE'S INFORMATION VIA THE Cart AND Modal CLASSES, TO ADD AN ARTICLE TO A
//CART AND TO DISPLAY A CART VIA THE DisplayCart CLASS***********************************************//

export default class Article {
    
    constructor() {
        this.cart = new Cart();
        this.modal = new Modal();
    }
    
//*****1. Finding an article's information*****//
    createArticle(event) {
        
//*****A. Finding an article's information: ID, name, price, via the datasets of HTML tags*****//
        const parentElement = event.target.parentElement;
        const id = parentElement.dataset.id;
        const name = parentElement.querySelector('p').dataset.name;
        const price = +parentElement.dataset.price;
        
//*****B. Calling a function to add an article*****//
        this.addArticle(id, price, name);
    }

//*****2a. Adding an article to the cart*****//    
    addArticle(articleId, articlePrice, articleName) {
        
//*****A. Calling a function to load a cart's data storage*****//
        const shoppingCart = this.cart.loadCart();
        
//*****B. Defining an article as a JavaScript item, with: ID, name, price, quantity*****//
        const article = {
                        id : articleId,
                        name : articleName,
                        price : articlePrice,
                        quantity : 1
                        };
                        
//*****C. Looping on a cart's data storage*****//
        for(let i = 0; i < shoppingCart.length; i++) {
            
//*****i. If the ID of the cart's data storage matches the ID of the article*****//          
            if(shoppingCart[i].id == article.id) {
                
//*****Increasing an article's quantity, saving a cart's data storage and refreshing the cart's icon*****//
                shoppingCart[i].quantity++;
                this.cart.saveCart(shoppingCart); 
                this.refreshCartIcon(); 
                return;
                
//*****END OF THE IF CONDITION*****//
            }
            
//*****END OF THE FOR LOOP*****//
        }
        
//*****D. Displaying an added article in a cart, updating the latter and refreshing the cart's icon*****//
        shoppingCart.push(article);
        this.cart.saveCart(shoppingCart);
        this.refreshCartIcon();
        
//*****END OF THE addArticle() METHOD*****//      
    }
    
//*****2b. Deleting an article*****//
    deleteArticle(event) {
        
//*****A. Calling a function to load a cart's data storage*****//
        const shoppingCart = this.cart.loadCart();
        
//*****B. Deleting an article according to its ID*****//
        const newShopcart = shoppingCart.filter(article => article.id != event.dataset.deleteId);

//*****C. Saving a cart's data storage, updating the latter and refreshing the cart's icon*****//
        this.cart.saveCart(newShopcart);
        new DisplayCart();
        this.refreshCartIcon();
    }
    
//*****3. Displaying a total amount*****//
    refreshCartIcon() {
        
//*****A. Hiding a modal used for article addition*****//
        if(document.getElementById('booking-modal')) {
            this.modal.hideModal();
        }
        
//*****B. Calling a function to load a cart's data storage*****//
        const shoppingCart = this.cart.loadCart();
        
//*****C. Fixing a total amount for each added article, with a loop*****//
        let totalAmount = 0.0;
        
        for(const item of shoppingCart) {
            totalAmount += item.price * item.quantity;
        }
        
//*****D. Fixing a cart's total amount, and displaying it as a float with two decimals*****//
        document.querySelector('.shop span').textContent = totalAmount.toFixed(2);
        
//*****END OF THE refreshCartIcon() METHOD*****//
    }
    
//*****END OF the Article CLASS*****//
}
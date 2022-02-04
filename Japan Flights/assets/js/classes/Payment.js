import Article from './Article.js';
import Cart from './Cart.js';

//*****GOALS: TO CREATE A PAYMENT FORM WITH THE Stripe API, AND TO CONTROL THE PAYMENT PROCESS//
//********************************************************************************************//

//*****METHODS: TO EMPTY A CART AND REFRESH THE CART'S ICON VIA THE Cart AND Article CLASSES, TO FIND
//AN ORDER'S ID AND TOTAL AMOUNT AND TO RETURN THEM IN THE PAYMENT FORM****************************//

//*****1. Instantiating classes*****//
const CartClass = new Cart();
const ArticleClass = new Article();

export default class Payment {
    
//*****1. Enabling payment with a public key*****//
    initStripe(publicKey) {
        this.stripe = publicKey;
    }
    
//*****2. Creating a payment form via the Stripe API*****//
    makeForm() {
        this.form = this.stripe.elements().create('card', {hidePostalCode :true });
        this.form.mount('.form-payment');
    }
    
//*****3. Controlling payment*****//
    payment(event) {

//*****A. Finding a card owner's name, via the value and dataset of HTML tags*****//
        const owner = document.querySelector(".cardholder-name").value; 
        const secretClient = document.querySelector(".card-button").dataset.secret;

//*****B. Payment intent*****//
        this.stripe
        
//*****i. Finding the payment details: payment method, amount due, card owner's name*****//
        .confirmCardPayment(
                            secretClient, 
                            { payment_method: {card: this.form, billing_details: {name: owner} }}
                            )
                            
//*****ii. Returning the result of the paymeny intent*****//
        .then((result) => {
            
//*****If an error occured*****/
            if(result.error) {
                
//*****Cancelling payment and to return an error message*****//
                document.querySelector(".errors").textContent = result.error.message;
            }
            
//*****If no error occured*****//
            else {

//*****Finding an order's total amount and ID, via the datasets of HTML tags*****//
                const amount = document.querySelector('[data-amount]').dataset.amount;
                const order  = document.querySelector('[data-order]').dataset.order;
                
//*****Emptying a cart and refreshing the cart's icon*****/
                CartClass.clearCart();
                ArticleClass.refreshCartIcon(); 
                
//*****Returning an order's ID in the URL of the form action*****//
                document.location.href = `index.php?p=updateorder&amount=${amount}&orderId=${order}`;
                
//*****END OF THE ELSE CONDITION*****//
            }

//*****END OF THE PAYMENT INTENT*****//
        });

//*****END OF THE payment() METHOD*****//
    }
  
//*****END OF THE Payment CLASS*****// 
}
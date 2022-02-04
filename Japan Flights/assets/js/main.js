import Article from './classes/Article.js';
import Cart from './classes/Cart.js';
import DisplayCart from './classes/DisplayCart.js';
import Filter from './classes/Filter.js';
import FontAwesome from './classes/FontAwesome.js';
import Modal from './classes/Modal.js';
import Order from './classes/Order.js';
import Payment from './classes/Payment.js';

//*****GOALS: TO LAUNCH MISCELLANEOUS FUNCTIONS AND TO LAUNCH CLASSES' METHODS WITH EVENTS//
//****************************************************************************************//

//*****METHODS: TO INSTANTIATE JAVASCRIPT CLASSES, TO DETERMINE EVENTS AND TO CALL THE CLASSES' METHODS
//***************************************************************************************************//

//*****1. Instantiating classes*****//

const ArticleClass = new Article();
const CartClass = new Cart();
const FontAwesomeClass = new FontAwesome();
const ModalClass = new Modal();
const PaymentClass = new Payment();
    
//*****2. Classes' methods*****//

//*****A. Events when the DOM content is loaded*****//
document.addEventListener('DOMContentLoaded', () => {

//*****i. Instantiating the FontAwesome class, and calling the method made to create arrows*****//
    FontAwesomeClass.createArrows();
    
//*****ii. Instantiating the Article class, and calling the method made to refresh the cart's icon*****//
    ArticleClass.refreshCartIcon();
    
//*****iii. Instantiating the Filter class, to display the average rating of each destination*****//
    if(document.querySelector('.average-rating1')) {
        new Filter('average-rating1');
    }
    
    if(document.querySelector('.average-rating2')) {
        new Filter('average-rating2');
    }
    
    if(document.querySelector('.average-rating3')) {
        new Filter('average-rating3');
    }
    
    if(document.querySelector('.average-rating4')) {
        new Filter('average-rating4');
    }
    
    if(document.querySelector('.average-rating5')) {
        new Filter('average-rating5');
    }
    
//*****iv. Instantiating the DisplayCart class in the Cart page*****//
    if(document.querySelector('.shopping-cart')) {
        new DisplayCart();
    }
    
//*****v. Instantiating the DisplayCart class in the Order page*****//
    if(document.querySelector('.order-cart')) {
        new DisplayCart('order');
    }
    
//*****vi. Instantiating the Payment Class in the Payment page*****//
    if(document.getElementById('payment-form')) {
        
//*****Hiding the cart's icon*****//
        document.querySelector('.shop').style.display = 'none';
        
//*****Launching the Stripe API method made to enable payment*****//
        PaymentClass.initStripe(Stripe('pk_test_51J3HfUIgx08Ao9u6E0cs7oImi1DqcW8ZaPoEieyhRtsWslUk8Bd0M4V3ad65eqpGL1N3E77f5t8sfN93l5LRenXZ00R4h8kSdO'));
        
//*****Launching the Payment class method made to create the payment form*****//
        PaymentClass.makeForm();
    }
    
//*****vii. Instantiating the FontAwesome class in the Review page, and calling the method made to give a
//*****rating with stars*******************************************************************************//
    if(document.getElementById('sendReview')) {
        FontAwesomeClass.reviewStars();
    }

//*****END OF THE EVENTS WHEN THE DOM CONTENT IS LOADED*****//
});

//*****B. Click events on buttons or links*****//
document.addEventListener('click', event => {
    
//*****i. Instantiating the Modal class in the Destinations page, after a buying button was clicked*****//
    if(event.target.matches('.buy button')) {
        ModalClass.createModal(event);
    }
    
//*****ii. Instantiating the Article class in the Destinations page, if a user chose to add an article
//to the cart*****************************************************************************************//
    if(event.target.matches('.add-article')) {
        ArticleClass.createArticle(event);
    }
    
//*****iii. Closing the modal, if a user chose not to add an article to the cart*****//    
    if(event.target.matches('.add-not-article')) {
        ModalClass.hideModal();
    }
    
//*****iv. Emptying a cart, if a user chose to do so*****//       
    if(event.target.matches('.clear-cart')) {
        
//*****Instantiating the Cart class in the Cart page, and calling the method made to empty a cart*****//
        CartClass.clearCart();
        
//*****Instantiating the Article class, and calling the method made to refresh the cart's icon anew*****//
        ArticleClass.refreshCartIcon();
        
//*****Instantiating the DisplayCart class in the Cart page anew*****//
        new DisplayCart();
    }
    
//*****v. Instantiating the Article class in the Cart page, and calling the method made to delete an 
//article from a cart, if a user chose to do so***************************************************//
    if(event.target.matches('[data-delete-id]')) {
        ArticleClass.deleteArticle(event.target);
    }
    
//*****vi. Instantiating the Order class in the Order page, and calling the method made to save order lines after a cart validation******************************************************************//  
    if(event.target.matches('.confirm-order')) {
        event.preventDefault();
        new Order('save-orderlines');
    }
    
//*****vii. Instantiating the Payment class in the Payment page, and calling the method about payment via
//the Stripe API***************************************************************************************//     
    if(event.target.matches('.card-button')) {
        PaymentClass.payment(event);
    }

//*****END OF THE CLICK EVENTS*****//       
});

//*****3. Miscellaneous functions from the function.js file*****//

//*****A. Responsive data label change*****//
changeDataLabel();

//*****B. Restrictions for accesssing the cart's icon*****//

hideCartIcon();

//*****C. Restrictions for accessing the link to the review form*****//

hideReviewLink();
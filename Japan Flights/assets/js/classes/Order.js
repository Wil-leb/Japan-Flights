import Cart from './Cart.js';

//*****GOAL: TO SAVE ORDER LINES, IF A USER VALIDATES A CART//
//**********************************************************//

//*****METHODS: TO CHECK IF A USER VALIDATES A CART, TO LOAD A CART'S CONTENT VIA THE Cart CLASS AND TO
//SAVE THE ORDER LINES*******************************************************************************//

export default class Order {
    
    constructor(action) {
        this.cartClass = new Cart(); 
        this.check(action);
    }
    
//*****1.Checking if a user validates a cart*****//
    check(action) {
        
//*****A. Cart validation*****//
        switch(action) {
            case 'save-orderlines':
                
//*****i. Calling a function to save the order lines*****// 
                this.saveOrderlines();
            break;
//*****END OF THE SWITCH CONDITION*****//
        }
        
//*****END OF THE check() METHOD*****//
    }
    
//*****2. Saving order lines*****//
    saveOrderlines() {

//*****A. Loading a cart's content*****//
        const orderlines = this.cartClass.loadCart();

//*****B. Finding an order's ID, via the dataset of a HTML tag*****//
        const orderId = document.querySelector('[data-order]').dataset.order;
        
//*****C. Looping on the order lines*****//
        for(const orderline of orderlines) {

//*****i. Creating a form and appending information in it: article ID, order ID, article quantity*****// 
            const form = new FormData();
            
            form.append('article_id', orderline.id);
            form.append('order_id', orderId);
            form.append('quantity', orderline.quantity);
            
//*****ii. Fetching a URL linked to a form action*****//
            fetch('index.php?ajax=saveOrderlines', { method: 'POST', body: form })
            
//*****iii. Asking to return, in text format, the information appended to the form*****// 
            .then(response => response.text())
            
//*****iv. Asking to return the information in a selected <div>, and to return an order's ID in the URL of
//the payment page************************************************************************************// 
            .then((res) => {
                            document.querySelector('.info').innerHTML = res;
                            document.location.href = "index.php?p=payment&orderNum="+orderId;
                            });

//*****END OF THE FOR LOOP*****//
        }
        
//*****END OF THE saveOrderlines() METHOD*****//
    }
    
//*****END OF THE Order CLASS*****//
}
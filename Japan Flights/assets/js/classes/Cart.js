import DataStorage from './DataStorage.js';

//*****GOALS: TO LOAD AND SAVE A CART'S DATA STORAGE IF IT IS FILLED, AND TO CLEAR A CART'S DATA STORAGE
//IF IT IS EMPTY**************************************************************************************//

//*****METHOD: TO FIND AN ARTICLE'S INFORMATION VIA THE DataStorage CLASS*****//

export default class Cart {

    constructor() {
        this.cart = new DataStorage();
    }

//*****1. Loading a cart's data storage*****//
    loadCart() {
        let shoppingCart = this.cart.loadDataFromDomStorage('shop');
        
//*****A. Loading an empty cart if there is no data storage in it*****//
        if (shoppingCart == null) {  
            shoppingCart = [];  
        }
        
        return shoppingCart;
    }
    
//*****2a. Saving a cart's data storage*****//
    saveCart(cart) {   
        this.cart.saveDataToDomStorage('shop', cart);
    }
    
//*****2b. Clearing a cart's data storage*****//
    clearCart() {
        localStorage.clear();
    }
    
//*****END OF THE Cart CLASS*****//
}
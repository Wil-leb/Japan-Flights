export default class Modal {
    
//*****GOALS: TO DISPLAY A MODAL WHEN AN ARTICLE IS CHOSEN, AND TO HIDE A MODAL WHEN A BUTTON IS
//*****CLICKED*********************************************************************************//

//*****METHODS: TO FIND AN ARTICLE'S INFORMATION, TO DISPLAY IT IN THE MODAL AND TO CLOSE THE MODAL*****//

//*****1. Finding an article's information*****//
    createModal(event) {
        
//*****A. Finding an article's information: ID, price, name, via the datasets of HTML tags*****//
        const parentElement = event.target.parentElement;
        const id = event.target.parentElement.dataset.id;
        const name = parentElement.querySelector('h2').dataset.name;
        const price = +parentElement.querySelector('h3').dataset.price;
        
//*****B. Calling a function to display an article's information*****//
        this.displayModal(id, price, name);
    }
    
//*****2. Displaying a modal*****//
    displayModal(articleId, articlePrice, articleName) {
        
//*****A. Fixing the content of a selected <div> in the modal*****//
        document.getElementById('booking-modal').innerHTML = 	
    	`<div class="modal" data-price=${articlePrice} data-id=${articleId}>
    		<p data-name=${articleName}>Do you want to add a flight to ${articleName} to the cart?</p>
    		<button class="add-article">Yes</button>
    		<button class="add-not-article">No</button>
    	</div>`;
    }
    
//*****3. Hiding a modal*****//  
    hideModal() {
        document.getElementById('booking-modal').innerHTML = '';
    }
    
//*****END OF THE Modal CLASS*****//
}
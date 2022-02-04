//*****GOAL: TO CREATE MISCELLANEOUS FUNCTIONS THAT DO NOT NEED TO BE IN ANY CLASSES*****//
///**************************************************************************************//

//*****METHOD: TO DECLARE FUNCTIONS TO BE CALLED IN THE main.js FILE*****//

//*****1. Changing the 'Description' data label of the Article dashboard's table*****//
function changeDataLabel() {
    
//*****A. Selecting a table's data label*****//
    let articleDescriptions = document.querySelectorAll('#description');

//*****B. Looping on each selected data label*****//
    for(let articleDescription of articleDescriptions) {

//*****i. Change the data label's value if the screen's width is inferior to a specified size*****//
        if(screen.width < 576) {
            articleDescription.dataset.label = 'Descr.';
        }

//*****END OF THE FOR LOOP
    }
    
//*****END OF THE changeDataLabel() FUNCTION
}

//*****2. Preventing a user to access the cart's icon from the Account page, or from the Review page*****//
function hideCartIcon() {
    
    if(document.location == 'https://wilfridleb.sites.3wa.io/PROJET%20FINAL/index.php?p=account'
        || document.location =='https://wilfridleb.sites.3wa.io/PROJET%20FINAL/index.php?p=review') {
            
//*****Instruction if one condition is met*****//
            document.querySelector('.shop').style.display = 'none';
    }
    
//*****END OF THE hideCartIcon() FUNCTION
}

//*****3. Preventing a user to access the link to the review form, if she/he is making an order, or if
//she/he is already in the Review page**************************************************************//

function hideReviewLink() {
    
    if(document.querySelector('.filled-cart') || document.querySelector('.form-payment') 
        || document.location == 'https://wilfridleb.sites.3wa.io/PROJET%20FINAL/index.php?p=success'
        || document.location =='https://wilfridleb.sites.3wa.io/PROJET%20FINAL/index.php?p=review') {
            
//*****Instruction if one condition is met*****//
        document.querySelector('.review-link').style.display = 'none';
    }
    
//*****END OF THE hideReviewLink() FUNCTION
}
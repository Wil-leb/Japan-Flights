export default class FontAwesome {
    
//*****GOALS: TO CREATE CLICKABLE ARROWS LINKING TO THE TOP AND THE BOTTOM OF THE PAGES, AND TO CREATE
//A RATING SYSTEM WITH STARS WHICH CAN BE HOVERED AND CLICKED****************************************//

//*****METHODS: TO CREATE TAGS, TO SET CONTENT TO THEM, TO APPEND THEM TO OTHER TAGS, TO STYLE THEM,
//TO SELECT THE STARS FOR THE RATING SYSTEM AND TO COLOR OR UNCOLOR THEM ACCORDING TO THE RATING VALUE,
//THANKS TO MOUSEOVER, CLICK AND MOUSEOUT EVENTS*****************************************************//

//*****1. Creating arrows*****//
    createArrows() {
        
//*****A. Selecting the <section> where to position the arrows*****//
        const firstSection = document.querySelector('section:first-of-type');
        const lastSection = document.querySelector('section:last-of-type');
        
//*****B. Creating <div> which will contain the arrows, and setting IDs which will be used as anchors*****//
        const pageTop = document.createElement('div');
        const pageBottom = document.createElement('div');
        pageTop.setAttribute('id', 'top');
        pageBottom.setAttribute('id', 'bottom');
        
//*****C. Creating <a>, and giving values corresponding with the anchors*****//
        const pageDown = document.createElement('a');
        const pageUp = document.createElement('a');
        pageDown.href = '#bottom';
        pageUp.href = '#top';
        
//*****D. Creating and styling <i>, which will contain classes corresponding with Font Awesome icons*****//
        const arrowDown = document.createElement('i');
        const arrowUp = document.createElement('i');
        
        arrowDown.setAttribute('class', 'fas fa-arrow-circle-down');
        arrowDown.style.display = 'block';
        arrowDown.style.textAlign = 'center';
        arrowDown.style.fontSize = '3rem';
        
        arrowUp.setAttribute('class', 'fas fa-arrow-circle-up');
        arrowUp.style.display = 'block';
        arrowUp.style.textAlign = 'center';
        arrowUp.style.fontSize = '3rem';
        arrowUp.style.marginTop = '2rem';
        
//*****E. Appending the created <i> to the created <a>*****//
        pageDown.append(arrowDown);
        pageUp.append(arrowUp);
        
//*****F. Appending the created <i> and the created <a> to the selected <section>*****//
        firstSection.prepend(pageTop, pageDown);
        lastSection.append(pageBottom, pageUp);
        firstSection.style.marginTop = '2rem';
        lastSection.style.marginBottom = '2rem';

//*****END OF THE createArrows() METHOD*****//        
    }

//*****2. Creating the rating system*****//
    reviewStars() {
        
//*****A. Selecting the stars to be used for the rating system*****//
        const stars = document.querySelectorAll('.stars .fa-star');
        
//*****B. Selecting the <input> containing a value corresponding with the number of stars clicked*****//
        const rating = document.getElementById('rating');

//*****C. Looping on the stars*****// 
        for(let i = 0; i < stars.length; i ++) {
            stars[i].style.fontSize = '2.5rem';
            
//*****i. Adding a mouseover event*****//
            stars[i].addEventListener('mouseover', function() {
                
//*****ii. Uncoloring the stars by default*****/
                uncolorStars();
                
//*****iii. Coloring the stars that were not already hovered*****//
                stars[i].style.color = 'rgba(255, 120, 0, 1)';
                
//*****iv. Coloring all the stars previous to the hovered one, with a loop*****//
                let previousStar = stars[i].previousElementSibling;
                
                while(previousStar) {
                    previousStar.style.color = 'rgba(255, 120, 0, 1)';
                    previousStar = previousStar.previousElementSibling;
                    
//*****END OF THE WHILE LOOP*****//
            }
            
//*****END OF THE MOUSEOVER EVENT*****//            
        });
        
//*****Modifying the value in the selected <input>, according to the position of the clicked star*****//
            stars[i].addEventListener('click', function() {
                rating.value = stars[i].dataset.value;
            });
            
//*****Fixing the number of colored stars to the rating value, when they are not hovered any more*****//
            stars[i].addEventListener('mouseout', function() {
                uncolorStars(rating.value);
            });
            
//*****END OF THE FIRST FOR LOOP*****//        
        }
        
//*****Uncoloring the stars that are too many, in comparison with the rating value*****//
        function uncolorStars(rate = 0) {
        
//*****Looping again on the stars*****//
            for(let i = 0; i < stars.length; i ++) {
                
//*****i. If the rating value exceeds the number colored stars*****//
                if(stars[i].dataset.value > rate) {
                    stars[i].style.color = 'unset';
                }
                
//*****ii. If the rating value does not exceed the number of colored stars*****//
                else {
                    stars[i].style.color = 'rgba(255, 120, 0, 1)';
                }
                
//*****END OF THE SECOND FOR LOOP*****//
            }
            
//*****END OF THE uncolorStars() NESTED METHOD*****//      
        }
        
//*****END OF THE reviewStars() PARENT METHOD*****//       
    }
    
//*****END OF THE FontAwesome CLASS*****//   
}
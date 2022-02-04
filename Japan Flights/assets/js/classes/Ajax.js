export default class Ajax {
    
//*****GOAL: TO DISPLAY THE AVERAGE RATING OF EACH DESTINATION*****//
//*****************************************************************//

//*****METHODS: TO FETCH THE URL OF EACH DESTINATION, AND TO DISPLAY THEIR RATING IN TEXT FORMAT*****//
    
//*****1a. First destination's URL*****//
    findRatingOne(url) {
        
//*****A. Fetching a URL*****/
        fetch(url)
        
//*****B. Asking to return a rating in text format*****// 
        .then(res => res.text())
        
//*****C. Calling a function to display a rating*****//
        .then(this.displayRatingOne);
    }
    
//*****1b. First destination's rating*****//
    displayRatingOne(rating) {
        
//*****Displaying a rating in a specific HTML tag*****//
        document.querySelector('.average-rating1').innerHTML = rating;
    }
    
//*****2a. Second destination's URL*****//
    findRatingTwo(url) {
        fetch(url)
        .then(res => res.text())
        .then(this.displayRatingTwo);
    }

//*****2b. Second destination's rating*****//    
    displayRatingTwo(rating) {
        document.querySelector('.average-rating2').innerHTML = rating;
    }
    
//*****3a. Third destination's URL*****//
    findRatingThree(url) {
        fetch(url)
        .then(res => res.text())
        .then(this.displayRatingThree);
    }
    
//*****3b. Third destination's rating*****//  
    displayRatingThree(rating) {
        document.querySelector('.average-rating3').innerHTML = rating;
    }

//*****4a. Fourth destination's URL*****//   
    findRatingFour(url) {
        fetch(url)
        .then(res => res.text())
        .then(this.displayRatingFour);
    }

//*****4b. Fourth destination's rating*****//    
    displayRatingFour(rating) {
        document.querySelector('.average-rating4').innerHTML = rating;
    }
    
//*****5a. Fifth destination's URL*****// 
    findRatingFive(url) {
        fetch(url)
        .then(res => res.text())
        .then(this.displayRatingFive);
    }

//*****5b. Fifth destination's rating*****//      
    displayRatingFive(rating) {
        document.querySelector('.average-rating5').innerHTML = rating;
    }

//*****END OF THE Ajax CLASS*****//    
}
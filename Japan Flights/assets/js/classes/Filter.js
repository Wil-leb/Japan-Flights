import Ajax from './Ajax.js';

export default class Filter {
    
//*****GOALS: TO DETERMINE THE URL OF EACH DESTINATION, AND TO LINK THEM TO THE METHODS OF THE Ajax CLASS//
//*******************************************************************************************************//

//*****METHODS: TO FILTER EACH DESTINATION THANKS TO THEIR ID, AND TO ASSOCIATE A URL CONTAINING THE
//*****DESTINATION'S NAME*************************************************************************//
    
    constructor(target) {
        this.AjaxClass = new Ajax();
        this.check(target);
    }
    
//*****Filtering the destinations*****//
    check(target) {
        
        switch(target) {
            case 'average-rating1':
                this.AjaxClass.findRatingOne('index.php?ajax=tokyo');
            break;
            
            case 'average-rating2':
                this.AjaxClass.findRatingTwo('index.php?ajax=kyoto');
            break;
            
            case 'average-rating3':
                this.AjaxClass.findRatingThree('index.php?ajax=osaka');
            break;
            
            case 'average-rating4':
                this.AjaxClass.findRatingFour('index.php?ajax=sapporo');
            break;
            
            case 'average-rating5':
                this.AjaxClass.findRatingFive('index.php?ajax=okinawa');
            break;
        }
        
//*****END OF THE check() METHOD*****//
    }
    
//*****END OF THE Filter CLASS*****//    
}
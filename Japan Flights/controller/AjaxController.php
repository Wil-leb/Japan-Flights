<?php

namespace App\controller;

//*****GOALS: TO SAVE AN ORDER'S LINES, AND TO DISPLAY THE AVERAGE RATING OF EACH DESTINATION//
//*******************************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND AN ORDER'S DETAILS AND THE DESTINATIONS' RATINGS,
//TO ENCODE AN ORDER'S DETAILS TO BE DISPLAYED IN A CART, AND TO FILTER EACH DESTINATION THX TO THEIR ID//

//*****1. Calling the appropriate model and the user session*****//
use App\model\{Article, OrderDetails};

class AjaxController {
    
//*****1. Saving order lines*****/
    public static function saveOrderlines() {

//*****A. Finding an order's lines and instantiating the OrderDetails model*****//
        $datas = $_POST;
        $orderDetails = new OrderDetails();

//*****B. Saving an order's lines
        $response = $orderDetails->addOrderDetails($datas);
        
//*****C. Encoding the response in JSON format*****//
        echo json_encode($response);
    }
    
    
//*****2. Displaying the average rating of each destination*****/

//*****A. First destination's rating*****//
    public static function tokyo() {
        
//*****i. Instantiating the Article model*****//
        $rating = new Article();
        
//*****ii. Finding the rating of a destination specified with its ID*****//
        $ratings = $rating->findAverageRatingByArticleId('1');

//*****iii. Calling the page in which to display the rating*****//       
        require './views/destinations/destinationPart.php';
    }
    
//*****B. Second destination's rating*****//    
    public static function kyoto() {
        $rating = new Article();
        $ratings = $rating->findAverageRatingByArticleId('2');
        require './views/destinations/destinationPart.php';
    }
    
//*****C. Third destination's rating*****//    
    public static function osaka() {
        $rating = new Article();
        $ratings = $rating->findAverageRatingByArticleId('3');
        require './views/destinations/destinationPart.php';
    }
    
//*****D. Fourth destination's rating*****//    
    public static function sapporo() {
        $rating = new Article();
        $ratings = $rating->findAverageRatingByArticleId('4');
        require './views/destinations/destinationPart.php';
    }
    
//*****E. Fifth destination's rating*****//    
    public static function okinawa() {
        $rating = new Article();
        $ratings = $rating->findAverageRatingByArticleId('5');
        require './views/destinations/destinationPart.php';
        
//*****END OF THE okinawa() METHOD*****//
    }
    
//*****END OF THE AjaxController CLASS*****//  
}
<?php

namespace App\controller;

//*****GOAL: TO ALLOW A CONNECTED USER TO SEND A REVIEW FOR A CHOSEN ARTICLE//
//**************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND THE ARTICLES' NAMES AND TO SAVE A REVIEW IF THE
//FORM WAS SUBMITTED WITH ALL THE REQUIREMENTS, OR NOT TO SAVE A REVIEW OTHERWISE*********************//


//*****1. Calling the appropriate models and the user session*****//
use App\model\{User, Review, Article};
use App\core\Session;

class ReviewController {
    
    protected Review $_review;
    public function __construct(Review $review) {
        $this->_review = $review;
    }
    
//*****2. Review form*****//  
    public function reviewForm(array $data) {

//*****A. Creating an empty array, that will contain error or succes messages*****//  
        $messages = [];
        
//*****B. Declaring variables, for content comparison with a regular expression*****//   
        $titleContent = $data['title'];
        $reviewContent = $data['content'];
        
//*****C. Declaring a regular expression, to allow only certain characters in the form fields and prevent
//injections in the databse****************************************************************************//
        $regex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-\/();,.!?"\s]*$/i';

//*****D. If the form is submitted*****//
        if(isset($_POST['sendReview'])) {
        
//*****i. If any fields were empty*****//
            if(empty($data['title']) || empty($data['title']) || empty($data['content']) || empty($data['rating'])) {
                $messages['errors'][] = 'Please fill in all the fields.';
            }
            
//*****iii. If the title or the cintent do not match their regular expression*****//
            if(!empty($data['title']) && !preg_match($regex, $titleContent, $matches)
                || !empty($data['content']) && !preg_match($regex, $reviewContent, $matches)) {
                $messages['errors'][] = 'Characters allowed for your review title and content: letters, numbers, dashes, slashes, parentheses, semicolons, commas, dots, periods, exclamation marks, question marks, straight double quotation marks and white spaces.';
            }
        
//*****iv. If all the requirements were met*****//
            if(empty($messages['errors'])) {

//*****Saving a review in the database*****/
                $this->_review->addReview($_SESSION['user']['id'], $data['articleSelect'],
                                            $_SESSION['user']['login'], $data['title'], $data['content'],
                                            $data['rating']);
                
//*****Fixing the content of the success message*****// 
                $messages['success'] = ['Thank you very much for taking the time to post a review!'];
                
//*****END OF THE IF CONDITION FOR THE REQUIREMENT CHECK*****// 
            }

//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//  
        }
        
        return $messages;
    }

//*****END OF THE RequestController CLASS*****//   
}
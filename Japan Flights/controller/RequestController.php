<?php

namespace App\controller;

//*****GOAL: TO ALLOW A CONNECTED USER TO SEND A REQUEST FOR A CHOSEN ORDER//
//*************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND A USER'S ORDERS, TO SAVE A REQUEST AND TO UPDATE
// AN ORDER IF THE FORM WAS SUBMITTED WITH ALL THE REQUIREMENTS, OR NOT TO SAVE A REQUEST NOR UPDATE AN
// ORDER OTHERWISE*************************************************************************************//


//*****1. Calling the appropriate models and the user session*****//
use App\model\{Orders, Request, User};
use App\core\Session;

class RequestController {
    
    protected Request $_request;
    public function __construct(Request $request) {
        $this->_request = $request;
    }
    
//*****2. Request form*****//    
    public function requestForm(array $data) {

//*****A. Creating an empty array, that will contain error or succes messages*****//        
        $messages = [];
        
//*****B. Declaring a variable, for content comparison with a regular expression*****//   
        $content = $data['customerRequest'];
        
//*****C. Declaring a regular expression, to allow only certain characters in the form fields and prevent
//injections in the databse****************************************************************************//     
        $regex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-\/();,.!?"\s]*$/i';
        
//*****D. If the form is submitted*****//
        if(isset($_POST['sendRequest'])) {
            
//*****i. Finding an order's ID*****//
            $orderId = $_GET['orderId'];
        
//*****ii. If any fields were empty*****//
            if(empty($data['requestSelect']) || empty($data['customerRequest'])) {
                $messages['errors'][] = 'Please fill in all the fields.';
            }
            
//*****iii. If the request does not match its regular expression*****//
            if(!empty($data['customerRequest']) && !preg_match($regex, $content, $matches)) {
                $messages['errors'][] = 'Characters allowed for your request: letters, numbers, dashes, slashes, parentheses, semicolons, commas, dots, periods, exclamation marks, question marks, straight double quotation marks and white spaces.';
            }
        
//*****iv. If all the requirements were met*****//
        
            if(empty($messages['errors'])) {
                
//*****Saving a request in the database*****/
                $this->_request->addRequest($_SESSION['user']['id'], $_SESSION['user']['email'],
                                            $_SESSION['user']['login'], $orderId, $data['requestSelect'],
                                            $data['customerRequest']);
                                      
//*****Instantiating the Orders model, and updating an order subject to cancellation request*****//
                if($data['requestSelect'] == 'cancellation') {
                    $order = new Orders();
                    $order->updateCancelledOrder($orderId);
                }
                
//*****Instantiating the Orders model, and updating an order subject to repayment request******//
                if($data['requestSelect'] == 'repayment') {
                    $order = new Orders();
                    $order->updateRepaidOrder($orderId);
                }

//*****Fixing the content of the success message*****//  
                $messages['success'] = ['Your request has been sent with success. You will receive an answer at your email address within 24 hours. Please check your spam folder in case our answer gets there.'];
                
//*****END OF THE IF CONDITION FOR THE REQUIREMENT CHECK*****//
            }
         
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//
        }
        
        return $messages;
    }

//*****END OF THE RequestController CLASS*****//     
}
<?php

namespace App\controller;

//*****GOAL: TO ALLOW A USER TO SEND A MESSAGE//
//********************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO SAVE A MESSAGE, IF THE FORM WAS SUBMITTED WITH ALL THE
//REQUIREMENTS, OR NOT TO SAVE A MESSAGE OTHERWISE****************************************************//

//*****1. Calling the appropriate model*****//

use App\model\ContactMessage;

class ContactMessageController {
    
    protected ContactMessage $_message;
    public function __construct(ContactMessage $message) {
        $this->_message = $message;
    }
    
//*****2. Contact form*****//   
    public function contactForm(array $data) {
        
//*****A. Creating an empty array, that will contain error or succes messages*****//
        $messages = [];
        
//*****B. Declaring variables, for content comparison with regular expressions*****//
        $lnameContent = $data['lastName'];
        $fnameContent = $data['firstName'];
        $messageContent = $data['message'];
        
//*****C. Declaring regular expressions, to allow only certain characters in the form fields and prevent
//injections in the databse***************************************************************************//
        $regex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ\-\s]*$/i';
        $contentRegex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-\/();,.!?"\s]*$/i';
        
//*****D. If the form is submitted*****//
        if(isset($_POST['sendMessage'])) {
            
//*****i. If any fields were empty*****//
            if(empty($data['lastName']) || empty($data['firstName']) || empty($data['email']) || empty($data['message'])) {
                $messages['errors'][] = 'Please fill in all the fields.';
            }
            
//*****ii. If the format of entered the email address is not valid*****//
            if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $messages['errors'][] = 'The format of the email address in not valid.';
            }
            
//*****iii. If the last name or the first name do not match their regular expression*****//
            if(!empty($data['lastName']) && !preg_match($regex, $lnameContent, $matches)
                || !empty($data['firstName']) && !preg_match($regex, $fnameContent, $matches)) {
                $messages['errors'][] = 'Characters allowed for your last name and first name: letters, dashes and white spaces.';
            }
            
//*****iv. If the message does not match its regular expression*****//
            if(!empty($data['message']) && !preg_match($contentRegex, $messageContent, $matches)) {
                $messages['errors'][] = 'Characters allowed for your message: letters, numbers, dashes, slashes, parentheses, semicolons, commas, dots, periods, exclamation marks, question marks, straight double quotation marks and white spaces.';
            }
            
//*****v. If all the requirements were met*****//
            if(empty($messages['errors'])) {
                
//*****Saving a message in the database*****//
                $this->_message->addMessage($data['lastName'],$data['firstName'],$data['email'],$data['message']);
                
//*****Fixing the content of the success message*****//                
                $messages['success'] = ['Your message has been sent with success. You will receive an answer at your email address within 24 hours. Please check your spam folder in case our answer gets there.'];

//*****END OF THE IF CONDITION FOR THE REQUIREMENT CHECK*****// 
            }
            
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//  
        }
        
        return $messages;
    }
 
//*****END OF THE ContactMessageController CLASS*****//  
}
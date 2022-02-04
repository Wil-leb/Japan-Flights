<?php

namespace App\controller;

//*****GOAL: TO ALLOW A USER TO REGISTER, AND TO ALLOW A USER TO LOG IN//
//*********************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND A USERS' INFORMATION, TO SAVE A NEW USER OR TO
//ALLOW CONNECTION IF A FORM WAS SUBMITTED WITH ALL THE REQUIREMENTS, OR NOT TO SAVE A USER NOR TO ALLOW
//CONNECTION OTHERWISE*********************************************************************************//

//*****1. Calling the appropriate model and the user cookie and session*****//

use App\model\{User};
use App\core\{Cookie, Session};

class FormController {
    
    protected User $_user;
    public function __construct(User $user) {
        $this->_user = $user;
    }
    
//*****2. Registration form*****//
    public function registrationForm(array $data) {
        
//*****A. Creating an empty array, that will contain error or succes messages*****//    
        $messages = [];
        
//*****B. Declaring regular expressions, to allow only certain characters in the form fields and prevent
//injections in the databse***************************************************************************//
        $loginContent = $data['login'];
        
//*****C. Declaring a variable, for content comparison with a regular expression*****//        
        $loginRegex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-_]*$/i';
        
//*****D. If any field is empty*****//
        if(empty($data['login']) || empty($data['password']) || empty($data['confirmPassword']) || empty($data['email'])) {
            $messages['errors'][] = 'Please fill in all the fields.';
        }
        
//*****E. If the format of the email address is not valid*****//
        if(!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $messages['errors'][] = 'The format of the email address is not valid.';
        }
        
//*****F. If the login is shorter than three characters, or longer than fifteen characters*****//
        if(!empty($data['login']) && strlen($data['login']) < 3 || strlen($data['login']) > 15) {
            $messages['errors'][] = 'Your login must contain 3 to 15 characters.';
        }

//*****G. If the the new login does not match its regular expression*****//
        if(!empty($data['login']) && !preg_match($loginRegex, $loginContent, $matches)) {
            $messages['errors'][] = 'Characters allowed for your login: letters, numbers, dashes and underscores.';
        }
            
//*****H. If the entered password and its confirmation do not match*****//
        if ($data['password'] !== $data['confirmPassword'] || $data['confirmPassword'] !== $data['password']) {
            $messages['errors'][] = 'The passwords must match.';
        }
            
//*****I. If the entered email is already used for another account*****//
        $email = $this->_user->findUserByEmail($data['email']);

        if($email) {
            $messages['errors'][] = 'This email address is already used for an existing account.';
        }
            
//*****J. If the entered login is already used for another account*****//
        $login = $this->_user->findUserByLogin($data['login']);
    
        if($login) {
            $messages['errors'][] = 'This login is already used for an existing account.';
        }
            
//*****K. If all the requirements were met*****//
        if(empty($messages['errors'])) {
            
//*****i. Savig a user in the database*****//
            $this->_user->addUserConnection($data['email'], $data['login'], $data['password']);
            
//*****Fixing the content of the success message*****//
            $messages['success'] = ['You have been registered with success!'];
        }
        
        return $messages;

//*****END OF THE registrationForm() METHOD*****//
    }
    
    
//*****2. Login form*****//
    public function loginForm(array $data) {
        
//*****A. If any field is empty*****//
        if(empty($data['login']) || empty($data['password'])) {
            return ['errors' => ['Please fill in all the fields.']];
        }
        
//*****B. Check of the entered login and password*****//
        else { 
            $exist = $this->_user->findUserByLogin($data['login']);
            
//*****i. If the entered login was not found in the DB*****//
            
            if(!$exist) {
                return ['errors' => ['This login does not exist.']];
            }
            
//*****ii. If the entered password was found in the DB*****//
            else if (password_verify($data['password'], $exist['password'])) {
                Session::setUserSession($exist);
                (isset($data['rememberMe'])) ? Cookie::setCookie($data):Cookie::deleteCookie($data);
            }
            
//*****If the entered password was not found in the DB*****//
            else {
                return ['errors' => ['The password is not valid.']];
//*****END OF THE ELSE CONDITION FOR THE EXISTING PASSWORD CHECK*****//  
            }
            
//*****END OF THE IF CONDITION FOR THE FIELD FILLING CHECK*****//  
        }
        
        if(empty($messages['errors'])) {
            
//*****Fixing the content of the success message*****//
            $messages['success'] = ['Hello, '.$data['login']];
        }
        
        return $messages;
        
//*****END OF THE loginForm() METHOD*****//        
    }

//*****END OF THE FormController CLASS*****//      
}
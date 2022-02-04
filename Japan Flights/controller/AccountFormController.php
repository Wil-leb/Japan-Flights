<?php

namespace App\controller;

//*****GOAL: TO ALLOW A USER TO CHANGE HER/HIS ACCOUNT INFORMATION, HER/HIS EMAIL, HER/HIS LOGIN OR
//HER/HIS PASSWORD*******************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND THE USER'S INFORMATION, TO UPDATE INFORMATION IF
//THE FORM WAS SUBMITTED WITH ALL THE REQUIREMENTS, OR NOT TO UPDATE THE INFORMATION OTHERWISE********//

//*****1. Calling the appropriate models and the user session*****//
use App\model\{User, Account};
use App\core\Session;

class AccountFormController {
    
    protected Account $_account;
    public function __construct(Account $account) {
        $this->_account = $account;
    }
    
//*****2. Account information form*****//
    public function accountForm(array $data) {
    
//*****A. Creating an empty array, that will contain error or succes messages*****//
        $messages = [];

//*****B. Declaring variables, for content comparison with regular expressions*****//
        $lnameContent = $data['newLastname'];
        $fnameContent = $data['newFirstname'];
        $addressContent = $data['newAddress'];
        $cityContent = $data['newCity'];
        $zipContent = $data['newZipcode'];
        $countryContent = $data['newCountry'];
        $phoneContent = $data['newPhone'];
        
//*****C. Declaring regular expressions, to allow only certain characters in the form fields and prevent
//injections in the databse***************************************************************************//
        $regex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ\-\s]*$/i';
        $addressRegex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-,\s]*$/i';
        $zipRegex = '/^[a-z0-9\-\s]*$/i';
        $phoneRegex = '/^[+]{1}[0-9\-\s.]*$/i';
        
//*****D. If the form is submitted*****//
        if(isset($_POST['confirmChanges'])) {

//*****i. Finding a user's ID*****//
            $id = $_SESSION['user']['id'];

//*****ii. If the new last name, first name, city or country do not match their regular expression*****//
            if(!empty($data['newLastname']) && !preg_match($regex, $lnameContent, $matches)
                || !empty($data['newFirstname']) && !preg_match($regex, $fnameContent, $matches)
                || !empty($data['newCity']) && !preg_match($regex, $cityContent, $matches)
                || !empty($data['newCountry']) && !preg_match($regex, $countryContent, $matches)) {
                    
//*****Instruction if one condition is met*****
                $messages['errors'][] = 'Characters allowed for your last name, first name, city and country: letters, dashes and white spaces.';
            }
            
//*****iii. If the new address does not match its regular expression*****//
            if(!empty($data['newAddress']) && !preg_match($addressRegex, $addressContent, $matches)) {
                $messages['errors'][] = 'Characters allowed for your address: letters, numbers, dashes, commas and white spaces.';
            }
            
//*****iv. If the new zip code does not match its regular expression*****//
            if(!empty($data['newZipcode']) && !preg_match($zipRegex, $zipContent, $matches)) {
                $messages['errors'][] = 'Characters allowed for your zip code: letters, numbers, dashes and white spaces.';
            }
            
//*****v. If the new phone number does not match its regular expression*****//
            if(!empty($data['newPhone']) && !preg_match($phoneRegex, $phoneContent, $matches)) {
                $messages['errors'][] = 'Pattern expected for your phone number: "plus" sign followed by digits, with possible separators such as dashes, white spaces or dots.';
            }
            
//*****vi. If all the requirements were met*****//
            elseif(empty($messages['errors'])) {
                
//*****Updating the user account information*****//
                $update = $this->_account->updateUserInfo($id, $data['newGender'], $data['newBirthdate'],
                                                            $data['newLastname'], $data['newFirstname'],
                                                            $data['newAddress'], $data['newCity'],
                                                            $data['newZipcode'], $data['newCountry'],
                                                            $data['newPhone']);
 
//*****Displaying the new user information in the Account page, and making sure that there are no extra
//spaces around any information**********************************************************************//
                $_SESSION['user']['gender'] = $data['newGender'];
                $_SESSION['user']['birthdate'] = $data['newBirthdate'];
                $_SESSION['user']['last_name'] = trim($data['newLastname']);
                $_SESSION['user']['first_name'] = trim($data['newFirstname']);
                $_SESSION['user']['address'] = trim($data['newAddress']);
                $_SESSION['user']['city'] = trim($data['newCity']);
                $_SESSION['user']['zip_code'] = trim($data['newZipcode']);
                $_SESSION['user']['country'] = trim($data['newCountry']);
                $_SESSION['user']['phone'] = trim($data['newPhone']);
                
//*****Fixing the content of the success message*****//
                $messages['success'] = ['Your information has been updated with success.'];
                
//*****END OF THE ELSEIF CONDITION*****//
            }
            
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//
        }
        
        return $messages;

//*****END OF THE accountForm() METHOD*****//
    }
    
//*****3. Account email form*****//
    public function emailForm(array $data) {

//*****A. Creating an empty array, that will contain error or succes messages*****//        
        $emailMessages = [];
        
//*****B. If the form is submitted*****//
        if(isset($_POST['confirmEmailchange'])) {

//*****i. Finding a user's ID*****//
            $id = $_SESSION['user']['id'];
            
//*****ii. Declaring variables to compare: current email, new email and its confirmation*****//
            $currentEmail = $data['currentEmail'];
            $newEmail = $data['newEmail'];
            $confirmNewemail = $data['confirmNewemail'];

//*****iii. Finding an email via a user's login*****//
            $exist = $this->_account->findUserByLogin($_SESSION['user']['login']);

//*****iv. If all the form fields were filled in*****//
            if(!empty($currentEmail) && !empty($newEmail) && !empty($confirmNewemail)) {
                
//*****If the entered current email was found in the database*****//
                if($currentEmail == $exist['email']) {
                    
//*****If the new email and its confirmation match*****//
                    if($newEmail == $confirmNewemail) {
                        
//*****If the entered new email is not already used for another account*****//
                        $email = $this->_account->findUserByEmail($newEmail);
                    
                        if(!$email) {
                            
//*****If the format of the new email s not valid*****//
                            if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL) ||
                                !filter_var($confirmNewemail, FILTER_VALIDATE_EMAIL)) {
                                $emailMessages['errors'][] = 'The format of the new email address is not valid.';
                            }
                            
//*****If the the format of the new email is valid*****//
                            else {
                        
//*****Updating the user account email*****//
                            $update = $this->_account->updateUserEmail($id, $newEmail);
                        
//*****Fixing the content of the success message*****//
                                $emailMessages['success'] = ['Your email has been updated with success.'];
                            }
                            
//*****END OF THE IF CONDITION FOR THE ALREADY USED EMAIL CHECK*****//                             
                        }
                        
//*****If the entered new email is already used for another account*****// 
                        else {
                            $emailMessages['errors'][] = 'This email address is already used for an existing account.';
                        }

//*****END OF THE IF CONDITION FOR THE EMAIL CONFIRMATION CHECK*****//                           
                    }
                    
//*****If the new email and its confirmation do not match*****//
                    else {
                        $emailMessages['errors'][] = 'The emails must match.';
                        
//*****END OF THE ELSE CONDITION FOR THE EMAIL CONFIRMATION CHECK*****//                         
                    }
                
//*****END OF THE IF CONDITION FOR THE EXISTING EMAIL CHECK*****// 
                }
        
//*****If the entered current email was not found in the database*****//
                
                else {
                    $emailMessages['errors'][] = 'The current email address is not valid.';
                }
                
//*****END OF THE IF CONDITION FOR THE FIELD FILLING CHECK*****//     
            }                    

//*****v. If any fields were empty*****//
        
            else {
                $emailMessages['errors'][] = 'Please fill in all the fields.';
            }

//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//  
        }
        
        return $emailMessages;
        
//*****END OF THE emailForm() METHOD*****//      
    }
    
//*****4. Account login form*****//
    public function loginForm(array $data) {

//*****A. Creating an empty array, that will contain error or succes messages*****//        
        $loginMessages = [];
        
//*****B. Checks when the form is submitted*****/
        if(isset($_POST['confirmLoginchange'])) {

//*****i. Finding a user's ID*****//
            $id = $_SESSION['user']['id'];
            
//*****ii. Declaring variables to compare: current login, new login and its confirmation*****//
            $currentLogin = $data['currentLogin'];
            $newLogin = $data['newLogin'];
            $confirmNewlogin = $data['confirmNewlogin'];

//*****iii. Finding a user's login*****//
            $exist = $this->_account->findUserByLogin($_SESSION['user']['login']);
            
//*****iv. If all the form fields were filled in*****//
            if(!empty($currentLogin) && !empty($newLogin) && !empty($confirmNewlogin)) {
                
//*****If the entered current login was found in the database*****//
                if($currentLogin == $exist['login']) {
                    
//*****If the new login and its confirmation match*****//
                    if($newLogin == $confirmNewlogin) {
                        
//*****If the entered new login is not already used for another account*****//
                        $login = $this->_account->findUserByLogin($newLogin);
                    
                        if(!$login) {
                        
//*****If the the new login does not match its regular expression*****//
                            $loginContent = $newLogin;
                            $loginConfirmed = $confirmNewlogin;
                            $loginRegex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-_]*$/i';
                            
                            if(!preg_match($loginRegex, $loginContent, $matches) ||
                                !preg_match($loginRegex, $loginConfirmed, $matches)) {
                                $loginMessages['errors'][] = 'Characters allowed for your login: letters, numbers, dashes and underscores.';
                            }
                            
//*****If the the new login matches its regular expression*****//
                            else {
                        
//*****Updating the user account login*****//
                            $update = $this->_account->updateUserLogin($id, $newLogin);
                        
//*****Fixing the content of the success message*****//
                                $loginMessages['success'] = ['Your login has been updated with success.'];
                            }
                            
//*****END OF THE IF CONDITION FOR THE ALREADY USED LOGIN CHECK*****//                             
                        }
                        
//*****If the entered new login is already used for another account*****// 
                        else {
                            $loginMessages['errors'][] = 'This login is already used for an existing account.';
                        }

//*****END OF THE IF CONDITION FOR THE LOGIN CONFIRMATION CHECK*****//                           
                    }
                    
//*****If the new login and its confirmation do not match*****//
                    else {
                        $loginMessages['errors'][] = 'The logins must match.';
                        
//*****END OF THE ELSE CONDITION FOR THE LOGIN CONFIRMATION CHECK*****//                         
                    }
                
//*****END OF THE IF CONDITION FOR THE EXISTING LOGIN CHECK*****// 
                }
        
//*****If the entered current login was not found in the database*****//
                
                else {
                    $loginMessages['errors'][] = 'The current login is not valid.';
                }
                
//*****END OF THE IF CONDITION FOR THE FIELD FILLING CHECK*****//     
            }                    

//*****v. If any fields were empty*****//
        
            else {
                $loginMessages['errors'][] = 'Please fill in all the fields.';
            }

//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//  
        }
        
        return $loginMessages;
        
//*****END OF THE loginForm() METHOD*****//      
    }
    
//*****5. Account password form*****//
    public function passwordForm(array $data) {

//*****A. Creating an empty array, that will contain error or succes messages*****//        
        $passwordMessages = [];
        
//*****B. If the form is submitted*****//
        if(isset($_POST['confirmPasswordchange'])) {

//*****i. Finding a user's ID*****//
            $id = $_SESSION['user']['id'];
            
//*****ii. Declaring variables to compare: current password, new password and its confirmation*****//
            $currentPassword = $data['currentPassword'];
            $newPassword = $data['newPassword'];
            $confirmNewpassword = $data['confirmNewpassword'];

//*****iii. Finding a password via a user's login*****//
            $exist = $this->_account->findUserByLogin($_SESSION['user']['login']);
            
//*****iv. If all the form fields were filled in*****//
                if(!empty($currentPassword) && !empty($newPassword) && !empty($confirmNewpassword)) {
                    
//*****If the entered current password was found in the database*****//
                    if($currentPassword == password_verify($currentPassword, $exist['password'])) {
                        
//*****If the new password and its confirmation match*****//
                        if($newPassword == $confirmNewpassword) {
                            
//*****Updating the user account password*****//
                            $update = $this->_account->updateUserPassword($id, $newPassword);
                            
//*****Hashing the new password*****//
                            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            
//*****Fixing the content of the success message*****//
                            $passwordMessages['success'] = ['Your password has been updated with success.'];
                        }
                        
//*****If the new password and its confirmation do not match*****//
                        else {
                            $passwordMessages['errors'][] = 'The passwords must match.';
                           
//*****END OF THE ELSE CONDITION FOR THE PASSWORD CONFIRMATION CHECK*****// 
                        }

//*****END OF THE IF CONDITION FOR THE EXISTING PASSWORD CHECK*****//                        
                    }
                    
//*****If the entered current password was not found in the database*****//
                    
                    else {
                        $passwordMessages['errors'][] = 'The current password is not valid.';
                    }
                    
                }
                
//*****v. If any fields were empty*****//
            
            else {
                $passwordMessages['errors'][] = 'Please fill in all the fields.';
            }


//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION*****//  
        }
        
        return $passwordMessages;
        
//*****END OF THE passwordForm() METHOD*****//      
    }
    
//*****END OF THE AccountFormController CLASS*****//    
}
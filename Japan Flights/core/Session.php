<?php

namespace App\core;

//*****GOALS: TO CONNECT TO THE DATABASE SO AS TO FIND A USER'S INFORMATION, TO CHECK IF A USER IS
//CONNECTED, AND TO CHECK IF A CONNECTED USER IS AN ADMIN OR NOT********************************//

//*****METHODS: TO FIND IF A SESSION IS OPEN, TO RETURN A SESSION INFORMATION IF YES, AND TO CHECK IF A
//USER IS REGISTERED AS AN ADMIN OR NOT**************************************************************//

class Session {
    
//*****1. Closing a session when a user disconnected*****//
    public static function disconnect(){
        session_start();
        session_destroy();
    }
    
    
//*****2. Setting a session when a user is connected*****//
    public static function setUserSession(array $sessions):void { 
        
//*****A. Setting a session's values with a user's information as keys, with a loop*****//
        foreach($sessions as $sessionKey => $sessionValue) {
            $sessionValue = self::checkInput($sessionValue);
            $_SESSION['user'][$sessionKey] = $sessionValue;
            
//*****END OF THE FOREACH LOOP*****//
        }

//*****END OF THE setUserSession() METHOD*****//
    }
    
    
//*****3. Returning a session's information*****//
    public static function checkInput($data) {
        
//*****A. Returning an integer, if a number was found*****//
        if(is_numeric($data)) {
            return intval($data);
        }
        
//*****B. Returning text, if something else than a number was found*****//
        
        else {
            return htmlspecialchars($data);
        }
       
//*****END OF THE checkInput() METHOD*****// 
    }
    
    
//*****4. Checking if a user is connected*****//
    public static function online():bool {
        
//*****A. If a session is open*****//
        if (array_key_exists('user', $_SESSION)) {
            return true;
        }
        
//*****B. If no session is open*****//
        
        else {
            return false;
        }
        
//*****END OF THE online() METHOD*****// 
    }
    
    
//*****5. Checking if a connected user is an admin*****//
    public static function admin() {
        
//*****A. Finding a user's role, if a session is open*****//
        if (array_key_exists('user', $_SESSION)) {
            $role = $_SESSION['user']['role'];
            
//*****i. If the user is an admin*****//
            if($role === 1) {
                return true;
            }
        
//*****ii. If the user is not an admin*****//
        
            else {
                return false;
            }
            
//*****END OF THE IF CONDITION FOR OPEN SESSION CHECK
        }
        
//*****END OF THE admin() METHOD*****//
    }

//*****END OF THE Session CLASS*****//   
}
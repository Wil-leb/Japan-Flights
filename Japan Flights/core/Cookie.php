<?php

namespace App\core;

//*****GOAL: TO MANAGE THE COOKIES' CREATION DELETION, ENCRYPTING AND DECRYPTING*****//
//***********************************************************************************//

//*****METHODS: TO FIND A USER'S CONNECTION DATA, TO SAVA DATA IN COOKIE, TO SET A DURATION TO A COOKIE,
//TO ENCRYPT A COOKIE WHEN SAVING DATA AND TO DECRYPT A COOKIE WHEN RETURNING DATA********************//

class Cookie {
    
//*****1. Deleting a cookie*****//
    public static function deleteCookie(array $cookies):void {
        
//****A. Finding and deleting the cookies, with a loop*****//
        foreach($cookies as $cookieKey => $cookieValue) {
            setcookie($cookieKey);                                                
            unset($_COOKIE[$cookieKey]);
            
//*****END OF THE FOREACH LOOP*****//
        }

//*****END OF THE deleteCookie() METHOD*****// 
    }
    
    
//*****2. Creating a cookie*****//
    public static function setCookie(array $cookies):void {
        
//****A. Saving a cookie's name, with a user's data as values, with a loop*****//
        foreach($cookies as $cookieName => $cookieValue) {

//*****i. Encrypting a password cookie*****//
            if($cookieName == 'password') {
                $cookieValue = self::encrypt($cookieValue);
            }
            
//*****ii. Saving a cookie's name and value, and making it valid for 24 minutes*****//
            setcookie($cookieName, $cookieValue, time()+365*24*3600);
            
//*****END OF THE FOREACH LOOP*****//
        }

//*****END OF THE setCookie() METHOD*****//        
    }
    
    
//*****3. Finding a cookie*****//
    public static function checkCookie(string $cookieName) {

//*****A. If a cookie was found*****//
        if(array_key_exists($cookieName, $_COOKIE)) {
            
//*****i. Decrypting a password cookie*****//
            if($cookieName == 'password') {
                $_COOKIE[$cookieName] = self::decrypt($_COOKIE[$cookieName]);
            }
             
//*****ii. Returning a cookie*****//                                               
            return "value='".$_COOKIE[$cookieName]."'";
            
//*****END OF THE IF CONDITION FOR COOKIE CHECKING*****// 
        }
        
//*****END OF THE checkCookie() METHOD*****// 
    }
    
    
//*****4. Encrypting a cookie*****//
    public static function encrypt(string $data) {
        
//*****A. Setting an encrypting key, and serializing a saved cookie*****//
        $key = "12345678";
        $data = serialize($data);
        
//*****B. Creating encryption*****//
        $td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

//*****C. Initializing encryption*****//
        mcrypt_generic_init($td, $key, $iv);
        $data = base64_encode(mcrypt_generic($td, '!' . $data));
        mcrypt_generic_deinit($td);
        
        return $data;
    }
    
    
//*****5. Decrypting a cookie*****//
    public static function decrypt(string $data) {

//*****A. Finding an encrypting key*****//        
        $key = '12345678';

//*****B. Creating encryption*****//        
        $td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        
//*****C. Initializing decryption*****//
        mcrypt_generic_init($td, $key, $iv);
        $data = mdecrypt_generic($td, base64_decode($data));
        mcrypt_generic_deinit($td);


//*****D. Extracting a serialized cookie*****//
        if (substr($data, 0, 1) != '!') {
            return false;
        }
        
        $data = substr($data, 1, strlen($data) - 1);
        
//*****Unserializing a saved cookie*****//
        return unserialize($data);
        
//*****END OF THE decrypt() METHOD*****// 
    }

//*****END OF THE Cookie CLASS*****//
}
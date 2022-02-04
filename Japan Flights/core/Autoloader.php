<?php
namespace App\core;

//*****GOAL: TO LOAD AUTOMATICALLY THE KNOWN EXISTING CLASSES*****//
//****************************************************************//

//*****METHODS: TO CALL THE NATIVE autoload() FUNCTION AND TO DECLARE NAMESPACES********//

class Autoloader {
    
//*****1. Loading the classes*****//
    static function register() {
        
//*****A. Calling the autoload() function*****//
        spl_autoload_register([
            __CLASS__,
            'autoload'
            
//*****END OF THE the autoload() FUNCTION*****//            
        ]);
        
//*****END OF THE register() METHOD*****//
    }
    
//*****2. Declaring the classes' namepsaces*****//
    static function autoload($namespace) {

//*****A. Replacing the blackslashes by regular slashes*****//
        $class = str_replace("\\", "/", $namespace);
        
//*****B. Replacing the 'App' namespace by a return to the current directory*****//
        $class = str_replace("App", ".", $class);
        
        require_once $class.'.php';
//*****END OF THE autoload() METHOD*****//
    }
    
//*****END OF THE Autoloader CLASS*****//
}
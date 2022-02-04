<?php

namespace App\core;

//*****GOALS: TO REDIRECT A USER TO A SPECIFIC PAGE, AFTER A SPECIFIC ACTION OR STATE, AND TO GIVE A CSS
//CLASS TO THE LINK OF AN ACTIVE PAGE******************************************************************//

//*****METHODS: TO REQUIRE A PAGE'S PATH, AND TO GIVE A CSS CLASS ACCORDING TO A PAGE'S PATH*****//

class Https {
    
//*****1. Redirecting a user*****//
    public static function redirect(string $path):void {
        header('Location: '.$path);
        exit;
    }
    
//*****2. Giving a CSS class to an active page*****//    
    public static function active(string $path) {
        return ($_GET['p'] === $path) ? "class = 'active'" : '';
    }

//*****END OF THE Https CLASS*****//
}
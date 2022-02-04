<?php

//*****GOALS: TO OPEN A SESSION EACH TIME A USER CONNECTS, TO ALLOW THE AUTOMATIC LOAD OF THE CLASSES,
//AND TO REDIRECT A USER TO A SPECIFIC PAGE, ACCORDING TO THE VALIDITY OR INVALIDITY OF A URL*******//

//*****METHODS: TO CALL A NATIVE SESSION FUNCTION, TO REQUIRE AN AUTOLOADER, TO DEFINE A ROUTER, TO CHECK
//IF A URL EXISTS IN AJAX OR IN PHP, AND TO REDIRECT A USER CONSEQUENTLY********************************//

//*****1. Calling the appropriate core files and controllers*****//
use App\core\{Autoloader, Https};
use App\controller\{FrontController, AjaxController};

//*****2. Opening a session*****//
session_start();

//*****3. Requiring an autoloader*****//
require_once './core/Autoloader.php';

//*****4. Instantiating the Autoloader class, and to call its method made to load the other classes*****//
Autoloader::register();

//*****5. Defining a router*****//
$routeur = new FrontController();

//*****6. Checking an AJAX URL, and redirecting to the Homepage if a URL does not exist*****//
if(isset($_GET['ajax'])) {
    $methodAjax = $_GET['ajax'];
    (method_exists(AjaxController::class, $methodAjax)) ? AjaxController::$methodAjax(): $routeur->home();
}
    
    
//*****7. Checking a PHP URL, and redirecting to the Homepage if a URL does not exist*****//
elseif(isset($_GET['p'])) {
    $method = $_GET['p'];
    (method_exists(FrontController::class, $method)) ? $routeur->$method(): $routeur->home();
}
    
//*****8. Redirecting to the Homepage by default, when entering the site, or if a URL does not exist*****//
else {
    header('Location: index.php?p=home');
    exit; 
}
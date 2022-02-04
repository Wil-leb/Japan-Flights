<?php

namespace App\model;

//*****GOALS: TO SAVE A CUSTOMER REQUEST IN THE DATABASE*****//
//***********************************************************//

//*****METHOD: TO COMMUNICATE WITH THE DATABASE VIA A REQUEST WITH NAMED VALUES, AND TO CALL THIS
//REQUEST IN THE APPROPRIATE CONTROLLER********************************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class Request extends Connect {

    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****2. Saving a request sent by a customer, with trims to prevent possible extra spaces around an
//entry*******************************************************************************************//
    
    public function addRequest(int $userId, string $userEmail, string $userLogin, int $ref,
                                string $subject, string $content) {
        
        $sql = "INSERT INTO `customer_request` (`user_id`, `user_email`, `user_login`, `order_reference`,                                      `request_subject`, `request_content`)
                VALUES (:userId, :userEmail, :userLogin, :ref, :subject, TRIM(:content))";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([
                ':userId' => $userId,
                ':userEmail' => $userEmail,
                ':userLogin' => $userLogin,
                ':ref' => $ref,
                ':subject' => $subject,
                ':content' => $content
        ]);
        
        return $this->_pdo->lastInsertId();
        
//*****END OF THE addRequest() METHOD*****//
    }

//*****END OF THE Request MODEL*****//   
}
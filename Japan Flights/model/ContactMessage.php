<?php
namespace App\model;

//*****GOAL: TO ALLOW A USER TO SEND A MESSAGE, FOR ANY QUESTIONS*****//
//********************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA A REQUEST WITH NAMED VALUES, AND TO CALL THIS
//REQUEST IN THE APPROPRIATE CONTROLLER*********************************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class ContactMessage extends Connect {

    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****2. Saving a message in the database, with trims to prevent possible extra spaces
//around an entry********************************************************************//
    public function addMessage(string $lastName, string $firstName, string $email, string $content) {
        
        $sql = "INSERT INTO `contact_message` (`visitor_last_name`, `visitor_first_name`,
                                                `visitor_email`, `message_content`)
                VALUES (TRIM(:lastName), TRIM(:firstName), :email, TRIM(:message))";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([
                        ':lastName' => $lastName,
                        ':firstName' => $firstName,
                        ':email' => $email,
                        ':message' => $content
                        ]);
        
//*****END OF THE addMessage METHOD*****//
    }

//*****END OF THE ContactMessage MODEL*****//
}
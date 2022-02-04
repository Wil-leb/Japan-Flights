<?php

namespace App\model;

//*****GOAL: TO SAVE A NEW USER IN THE DATABASE, AND TO FIND A USER'S INFORMATION*****//
//************************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class User extends Connect {
    
    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****2. Saving a new user in the table*****//
    public function addUserConnection(string $email, string $login, string $password) {
        
//*****A. Hashing a created password*****//
        $password = password_hash($password, PASSWORD_DEFAULT);
        
//*****B. Creating an INSERT request with named values*****//
        $sql = "INSERT INTO `user` (`email`, `login`, `password`)
                VALUES (:email, :login, :password)";

//*****C. Preparing the request*****//  
        $query = $this->_pdo->prepare($sql);

//*****D. Executing the request, and binding the named values to the method's parameters*****//
        $query->execute([
                        ':email' => $email,
                        ':login' => $login,
                        ':password' => $password
                        ]);
    }
    
//*****3. Finding all the existing users, for the Admin user dashboard*****//
    public function findAllUsers() {
        
        $sql = "SELECT `id`, `role`, `email`, `login`, `password`, `gender`, `birthdate`, `last_name`,
                        `first_name`, `address`, `city`, `zip_code`, `country`, `phone`
                FROM `user`";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute();
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
//*****4. Finding the existing email addresses, for the checks in the appropriate form controllers*****//
    public function findUserByEmail(string $email) {
        
        $sql = "SELECT `email`
                FROM `user`
                WHERE email = :email";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':email' => $email]);
            
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    

//*****5. Finding the existing email logins, for the checks in the appropriate form controllers, and to
//display a user's information in the Account page***************************************************//
    public function findUserByLogin(string $login) {
        
        $sql = "SELECT `id`, `role`, `email`, `login`, `password`, `gender`, `birthdate`, `last_name`,
                        `first_name`, `address`, `city`, `zip_code`, `country`, `phone`
                FROM `user`
                WHERE login = :login";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':login' => $login]);
            
        return $query->fetch(\PDO::FETCH_ASSOC);
        
//*****END OF THE findUserByLogin() METHOD*****//
    }

//*****END OF THE User MODEL*****//
}
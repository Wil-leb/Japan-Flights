<?php

namespace App\model;

//*****GOAL: TO FIND A USER'S INFORMATION AND TO UPDATE A USER'S MODIFIED INFORMATION IN THE DATABASE
//*************************************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class Account extends Connect {

    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****1. Finding the existing email addresses, for the checks in the appropriate form controllers*****//
    public function findUserByEmail(string $email) {
        
        $sql = "SELECT `email`
                FROM `user`
                WHERE `email` = :email";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':email' => $email]);
            
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

//*****2. Finding the existing email logins, for the checks in the appropriate form controllers, and to
//display a user's information in the Account page***************************************************//
    public function findUserByLogin(string $login) {
        
        $sql = "SELECT `id`, `role`, `email`, `login`, `password`, `gender`, `birthdate`, `last_name`,
                        `first_name`, `address`, `city`, `zip_code`, `country`, `phone`
                FROM `user`
                WHERE `login` = :login";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':login' => $login]);
            
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
//*****3. Updating a user's modified account information, with trims to prevent possible extra spaces
//around an entry**********************************************************************************//
    public function updateUserInfo(int $id, string $gender, string $birthdate, string $lastName,
                                    string $firstName, string $address, string $city, string $zipCode,
                                    string $country, string $phone) {
        
        $sql = "UPDATE `user`
                SET
                `gender` = :gender, `birthdate` = :birthdate, `last_name` = TRIM(:lastName), 
                `first_name` = TRIM(:firstName), `address` = TRIM(:address), `city` = TRIM(:city),
                `zip_code` = TRIM(:zipCode), `country` = TRIM(:country), `phone` = TRIM(:phone)
                WHERE id = :id";
            
        $query = $this->_pdo->prepare($sql);
    
        $query->execute([
                        ':id' => $id,
                        ':gender' => $gender,
                        ':birthdate' => $birthdate,
                        ':lastName' => $lastName,
                        ':firstName' => $firstName,
                        ':address' => $address,
                        ':city' => $city,
                        ':zipCode' => $zipCode,
                        ':country' => $country,
                        ':phone' => $phone
                        ]);
    }
    
//*****4. Updating a user's modified email*****//
    public function updateUserEmail(int $id, string $email) {
        $sql = "UPDATE `user`
                SET `email` = :email
                WHERE `id` = :id";
            
        $query = $this->_pdo->prepare($sql);
    
        $query->execute([
                        ':id' => $id,
                        ':email' => $email
                        ]);
    }
    
//*****5. Updating a user's modified login*****// 
    public function updateUserLogin(int $id, string $login) {
            
        $sql = "UPDATE `user`
                SET `login` = :login
                WHERE `id` = :id";
            
        $query = $this->_pdo->prepare($sql);
    
        $query->execute([
                        ':id' => $id,
                        ':login' => $login
                        ]);
    }
    
//*****6. Updating a user's modified password*****//
    public function updateUserPassword(int $id, string $password) {
        
//*****A. Hashing a created password*****//        
        $password = password_hash($password, PASSWORD_DEFAULT);
            
        $sql = "UPDATE `user`
                SET `password` = :password
                WHERE `id` = :id";
            
        $query = $this->_pdo->prepare($sql);
    
        $query->execute([
                        ':id' => $id,
                        ':password' => $password
                        ]);
                        
//*****END OF THE updateUserPassword() METHOD*****//
    }

//*****END OF THE Account MODEL*****//
}
<?php

namespace App\model;

//*****GOAL: TO ALLOW AN ADMIN TO MODIFY A CHOSEN ARTICLE, OR TO DELETE A CHOSEN REVIEW AND/OR A CHOSEN
//USER***********************************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class Admin extends Connect {
    
    protected $_pdo;
    public function __construct(){
        $this->_pdo = $this->connection();
    }
    
    
//*****2. Modifying an article*****//
    public function updateArticle(int $id, string $name, string $description, string $price,
                                    string $picture) {
        
        $sql = "UPDATE `article`
                SET
                `name` = TRIM(:name), `description` = TRIM(:description), `price` = :price,
                `picture` = :picture
                WHERE `id` = :id";
            
        $query = $this->_pdo->prepare($sql);
    
        $query->execute([
                        ':id' => $id,
                        ':name' => $name,
                        ':description' => $description,
                        ':price' => $price,
                        ':picture' => $picture
                        ]);
    }
    
//*****3. Deleting a review*****//
    public function deleteReview(int $id) {
        
        $sql = "DELETE FROM `review`
                WHERE `id` = :reviewId";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':reviewId' => $id]);
        
    }
    
//*****4. Deleting a user*****//
    public function deleteUser(int $id) {
        
        $sql = "DELETE FROM `user`
                WHERE `id` = :userId
                AND `role` = '0'";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':userId' => $id]);
    
//*****END OF THE deleteUser() METHOD*****//
    }

//*****END OF THE Admin MODEL*****//
}
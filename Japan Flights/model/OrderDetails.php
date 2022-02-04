<?php

namespace App\model;

//*****GOALS: TO SAVE AN ORDER'S DETAILS IN THE DATABASE, AND TO FIND AN ORDER'S DETAILS*****//
//*******************************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class OrderDetails extends Connect {
    
    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****1. Saving an order's details*****//
    public function addOrderDetails(array $data) {
                                
        $sql = "INSERT INTO `order_details` (`order_id`, `article_id`, `quantity`, `price`)
                VALUES (:orderId, :articleId, :quantity, :price)";
                
        $query= $this->_pdo->prepare($sql);
        
        $query->execute([
                        ':orderId' => $data['order_id'],
                        ':articleId' => $data['article_id'],
                        ':quantity' => $data['quantity'],
                        ':price' => $this->findArticlePrice($data['article_id'])
                        ]);
        
        return $data;
    }
    
//*****2. Finding a specific article's price, to be added in an order's details*****//
    public function findArticlePrice(int $articleId) {
        
        $sql = "SELECT `id`, `price`
                FROM `article`
                WHERE `id` = :articleId";
        
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':articleId' => $articleId]);
                    
        $value = $query->fetch(\PDO::FETCH_ASSOC); 
        
        return $value['price'];
    }
    
    
//*****3. Finding an order's details, to display in specific views*****//
    public function findOrderDetails(int $orderId) {
        $sql = "SELECT `id`, `order_id`, `article_id`, `quantity`, `price`
                FROM `order_details`
                WHERE `order_id` = :orderId";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':orderId' => $orderId]);
            
        return $query->fetchAll(\PDO::FETCH_ASSOC); 

//*****END OF THE findOrderDetails() METHOD*****//
    }

//*****END OF THE OrderDetails MODEL*****//
}
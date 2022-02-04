<?php

namespace App\model;

//*****GOALS: TO SAVE AN ORDER IN THE DATABASE, TO FIND A SPECIFIC ORDER THANKS TO ITS ID, TO FIND THE
//ORDERS OF A SPECIFIC USER THANKS TO THE LATTER'S ID, AND TO UPDATE AN ORDER'S STATUS AFTER A PAYMENT
//OR AFTER A CUSTOMER REQUEST***********************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class Orders extends Connect {
    
    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****2. Saving an order when a user validates a cart*****//
public function addOrder(int $userId) {
    
        $sql = "INSERT INTO `orders` (`user_id`) 
                VALUES (:userId)";
                
        $query= $this->_pdo->prepare($sql);
        
        $query->execute([':userId' => $userId]);
            
        return $this->_pdo->lastInsertId();
    }
    
//*****3. Finding a specific order thanks to its ID, so as to make a request for this one only*****//
public function findOrderById(int $orderId) {
        
        $sql = "SELECT orders.id, `user_id`, `total_price`, `order_date`, `payment`, `status`
                FROM `orders`
                LEFT OUTER JOIN `user`
                ON user.id = orders.user_id
                WHERE orders.id = :orderId
                ORDER BY `order_date` DESC";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':orderId' => $orderId]);
                
        return $query->fetch(\PDO::FETCH_ASSOC); 
    }
    
//*****4. Finding the orders of a specific user, so as to display her/his own orders only*****//
    public function findOrdersByUserId(int $userId) {
        
        $sql = "SELECT orders.id, user_id, `total_price`, `order_date`, `payment`, `status`
                FROM `orders`
                LEFT OUTER JOIN `user`
                ON user.id = orders.user_id
                WHERE user.id = :userId
                ORDER BY `order_date` DESC";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':userId' => $userId]);
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
//*****5. Updating a specific order, after a user made a payment with success*****//
    public function updateOrder(int $totalPrice, int $orderId) {
        
        $sql = "UPDATE `orders` 
                SET `total_price` = :totalPrice, `payment` = 'Done', `status` = 'Shipped'
                WHERE `id` = :orderId
                AND `payment` = 'Pending'
                AND `status` = 'Waiting payment'";
                
        $query= $this->_pdo->prepare($sql);
        
        $query->execute([
                        ':totalPrice' => $totalPrice,
                        ':orderId' => $orderId
                        ]);
    }
    
//*****6. Updating a specific order, after a user asked for a cancellation*****//
    public function updateCancelledOrder(int $orderId) {
        
        $sql = "UPDATE `orders` 
                SET `status` = 'Cancelled'
                WHERE `id` = :orderId
                AND `status` = 'Shipped'";
                
        $query= $this->_pdo->prepare($sql);
        
        $query->execute([':orderId' => $orderId]);
        
    }
    
//*****7. Updating a specific order, after a user asked for a repayment*****//
    public function updateRepaidOrder(int $orderId) {
        
        $sql = "UPDATE `orders` 
                SET `status` = 'Repaid'
                WHERE `id` = :orderId
                AND `status` = 'Cancelled'";
                
        $query= $this->_pdo->prepare($sql);
        
        $query->execute([':orderId' => $orderId]);

//*****END OF THE updateRepaidOrder() METHOD*****//
    }

//*****END OF THE Orders MODEL*****//
}
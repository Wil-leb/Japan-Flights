<?php

namespace App\model;

//*****GOALS: TO FIND ALL THE ARTICLES, TO FIND A SPECIFIC ARTICLE THANKS TO ITS ID, AND TO FIND THE
//AVERAGE RATING OF EACH ARTICLE******************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
use App\core\Connect;

class Article extends Connect {
    
    protected $_pdo;
    public function __construct(){
        $this->_pdo = $this->connection();
    }
    
//*****2. Finding all the articles, to display them in specific views*****//
    public function findAllArticles() {
        
        $sql = "SELECT `id`, `name`, `description`, `price`, `picture`, `creation_date`
                FROM `article`";
        
        $query = $this->_pdo->prepare($sql);
        
        $query->execute();
        
        return $query->fetchAll(\PDO::FETCH_ASSOC); 
    }


//*****3. Finding a specific article thanks to its ID, so as to display or modify only the one found*****//
    public function findArticleById(int $id) {
        
        $sql = "SELECT `id`, `name`, `description`, `price`, `picture`, `creation_date`
                FROM `article`
                WHERE `id` = :id";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':id' => $id]);
                
        return $query->fetch(\PDO::FETCH_ASSOC); 
    }
    
//*****4. Finding a specific article thanks to its ID, so as to display only its own average rating*****//
    public function findAverageRatingByArticleId(int $articleId) {
        
        $sql = "SELECT article.id, `article_id`, AVG(`rating`) AS `rate`
                FROM `article`
                LEFT OUTER JOIN `review`
                ON review.article_id = article.id
                WHERE article.id = :articleId
                GROUP BY article.id";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':articleId' => $articleId]);
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
        
//*****END OF THE findAverageRatingByArticleId() METHOD*****//
    }

//*****END OF THE Article MODEL*****//
}
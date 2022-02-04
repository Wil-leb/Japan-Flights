<?php

namespace App\model;

use App\core\Connect;

//*****GOALS: TO SAVE A REVIEW IN THE DATABASE, TO FIND ALL THE ARTICLES' REVIEWS AND TO FIND THE REVIEWS
//OF A SPECIFIC ARTICLE********************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE VIA REQUESTS WITH NAMED VALUES, AND TO CALL THESE
//REQUESTS IN THE APPROPRIATE CONTROLLERS AND VIEWS*********************************************//

//*****1. Calling the file to connect to the database*****//
class Review extends Connect {

    protected $_pdo;
    public function __construct() {
        $this->_pdo = $this->connection();
    }
    
//*****2. Saving a review posted by a user, with trims to prevent possible extra spaces around an
//entry****************************************************************************************//
    public function addReview(int $userId, int $articleId, string $userLogin, string $title, string $content, int $rating) {
        
        $sql = "INSERT INTO `review` (`user_id`, `article_id`, `user_login`, `title`, `content`, `rating`)
                VALUES (:userId, :articleId, :userLogin, TRIM(:title), TRIM(:content), :rating)";
                
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([
                        ':userId' => $userId,
                        ':articleId' => $articleId,
                        ':userLogin' => $userLogin,
                        ':title' => $title,
                        ':content' => $content,
                        ':rating' => $rating
                        ]);
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    
//*****3. Displaying all the article's reviews in the Admin review dashboard*****//
    public function findAllReviews() {
        
        $sql = "SELECT review.id, `user_id`, `article_id`, `user_login`, `title`, `content`, `rating`,
                        `post_date`
                FROM `review`
                LEFT OUTER JOIN `user` ON review.user_id = user.id
                ORDER BY review.id DESC";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute();
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
//*****4. Displaying the reviews of a specific article in its own Destination reviews page*****//
    public function findReviewsByArticleId(int $articleId) {
        
        $sql = "SELECT article.id, article_id, `user_login`, `title`, `content`, `rating`, `post_date`
                FROM `article`
                LEFT OUTER JOIN `review` ON review.article_id = article.id
                WHERE (SELECT `post_date` = MAX(`post_date`)) AND article.id = :articleId
                ORDER BY `rating` DESC, `post_date` DESC";
                    
        $query = $this->_pdo->prepare($sql);
        
        $query->execute([':articleId' => $articleId]);
        
        return $query->fetchAll(\PDO::FETCH_ASSOC);
        
//*****END OF THE findReviewsByArticleId() METHOD*****//
    }
    
//*****END OF THE Review MODEL*****//   
}
<?php
require_once __DIR__ . '/../config/database.php';

class Rating {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function addRating($visitorId, $rating, $comment = null) {
        $query = "INSERT INTO ratings (visitor_id, rating, comment, created_at) 
                  VALUES (:visitor_id, :rating, :comment, CURRENT_TIMESTAMP)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':visitor_id' => $visitorId,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }
    
    public function getAverageRating() {
        $query = "SELECT 
                    AVG(rating) as average,
                    COUNT(*) as total_ratings,
                    rating,
                    COUNT(*) as rating_count
                  FROM ratings 
                  GROUP BY rating
                  ORDER BY rating DESC";
        
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }
}
?>
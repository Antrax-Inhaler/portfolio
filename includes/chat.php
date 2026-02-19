<?php
require_once __DIR__ . '/../config/database.php';

class Chat {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function addMessage($visitorId, $message) {
        $query = "INSERT INTO chats (visitor_id, message, created_at) 
                  VALUES (:visitor_id, :message, CURRENT_TIMESTAMP)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':visitor_id' => $visitorId,
            ':message' => $message
        ]);
    }
    
    public function getRecentMessages($limit = 10) {
        try {
            $query = "SELECT c.*, v.ip_address 
                      FROM chats c
                      LEFT JOIN visitors v ON c.visitor_id = v.id
                      ORDER BY c.created_at DESC 
                      LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            // Ensure we always return an array
            return $result ?: [];
        } catch (PDOException $e) {
            error_log("Error getting recent messages: " . $e->getMessage());
            return []; // Return empty array on error
        }
    }
}
?>
<?php
require_once __DIR__ . '/../config/database.php';

class Message {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function sendMessage($data) {
        $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
        
        $query = "INSERT INTO messages (name, email, subject, message, section, ip_address, created_at) 
                  VALUES (:name, :email, :subject, :message, :section, :ip, CURRENT_TIMESTAMP)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':subject' => $data['subject'] ?? null,
            ':message' => $data['message'],
            ':section' => $data['section'],
            ':ip' => $ip
        ]);
    }
}
?>
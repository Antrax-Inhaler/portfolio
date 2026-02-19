<?php
require_once __DIR__ . '/../config/database.php';

class Visitor {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    public function trackVisitor($section) {
        $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        
        $query = "INSERT INTO visitors (ip_address, user_agent, visited_section, visit_time) 
                  VALUES (:ip, :ua, :section, CURRENT_TIMESTAMP) 
                  RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':ip' => $ip,
            ':ua' => $userAgent,
            ':section' => $section
        ]);
        
        $result = $stmt->fetch();
        return $result['id'];
    }
    
    public function getVisitorStats() {
        $query = "SELECT 
                    COUNT(*) as total_visitors,
                    COUNT(DISTINCT ip_address) as unique_visitors,
                    visited_section,
                    COUNT(*) as section_count
                  FROM visitors 
                  GROUP BY visited_section
                  ORDER BY section_count DESC";
        
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }
}
?>
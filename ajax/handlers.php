<?php
require_once __DIR__ . '/../includes/visitor.php';
require_once __DIR__ . '/../includes/rating.php';
require_once __DIR__ . '/../includes/message.php';
require_once __DIR__ . '/../includes/chat.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'track_visit':
            $visitor = new Visitor();
            $section = $_POST['section'] ?? 'home';
            $visitorId = $visitor->trackVisitor($section);
            echo json_encode(['success' => true, 'visitor_id' => $visitorId]);
            break;
            
        case 'add_rating':
            $rating = new Rating();
            $visitorId = $_POST['visitor_id'] ?? null;
            $ratingValue = $_POST['rating'] ?? null;
            $comment = $_POST['comment'] ?? null;
            
            if (!$visitorId || !$ratingValue) {
                throw new Exception('Visitor ID and rating are required');
            }
            
            $result = $rating->addRating($visitorId, $ratingValue, $comment);
            echo json_encode(['success' => $result]);
            break;
            
        case 'send_message':
            $message = new Message();
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'subject' => $_POST['subject'] ?? '',
                'message' => $_POST['message'] ?? '',
                'section' => $_POST['section'] ?? 'contact'
            ];
            
            if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
                throw new Exception('Name, email, and message are required');
            }
            
            $result = $message->sendMessage($data);
            echo json_encode(['success' => $result]);
            break;
            
        case 'add_chat':
            $chat = new Chat();
            $visitorId = $_POST['visitor_id'] ?? null;
            $message = $_POST['message'] ?? '';
            
            if (!$visitorId || empty($message)) {
                throw new Exception('Visitor ID and message are required');
            }
            
            $result = $chat->addMessage($visitorId, $message);
            echo json_encode(['success' => $result]);
            break;
            
        case 'get_chats':
            $chat = new Chat();
            $messages = $chat->getRecentMessages(20);
            echo json_encode($messages); // This should be an array
            break;
            
        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
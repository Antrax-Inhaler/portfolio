<?php
require_once 'includes/visitor.php';
require_once 'includes/rating.php';
require_once 'includes/message.php';
require_once 'includes/chat.php';

$visitor = new Visitor();
$rating = new Rating();
$message = new Message();
$chat = new Chat();

$visitorStats = $visitor->getVisitorStats();
$ratingStats = $rating->getAverageRating();
$recentMessages = $message->getRecentMessages(20);
$recentChats = $chat->getRecentMessages(20);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card h2 {
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background: #667eea;
            color: white;
        }
        
        tr:hover {
            background: #f9f9f9;
        }
        
        .section-title {
            margin: 2rem 0 1rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="card">
                <h2>Visitor Stats</h2>
                <?php foreach ($visitorStats as $stat): ?>
                    <p><strong><?php echo ucfirst($stat['visited_section'] ?: 'Unknown'); ?>:</strong> 
                    <?php echo $stat['section_count']; ?> visits</p>
                <?php endforeach; ?>
            </div>
            
            <div class="card">
                <h2>Rating Stats</h2>
                <?php 
                $totalRatings = 0;
                $totalSum = 0;
                foreach ($ratingStats as $stat): 
                    $totalRatings += $stat['rating_count'];
                    $totalSum += $stat['rating'] * $stat['rating_count'];
                ?>
                    <p><strong><?php echo $stat['rating']; ?> Stars:</strong> 
                    <?php echo $stat['rating_count']; ?> ratings</p>
                <?php endforeach; ?>
                <?php if ($totalRatings > 0): ?>
                    <p><strong>Average Rating:</strong> 
                    <?php echo round($totalSum / $totalRatings, 2); ?>/5</p>
                <?php endif; ?>
            </div>
        </div>
        
        <h2 class="section-title">Recent Messages</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentMessages as $msg): ?>
                <tr>
                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                    <td><?php echo htmlspecialchars(substr($msg['message'], 0, 50)) . '...'; ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($msg['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h2 class="section-title">Recent Chats</h2>
        <table>
            <thead>
                <tr>
                    <th>Visitor ID</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentChats as $chat): ?>
                <tr>
                    <td><?php echo $chat['visitor_id'] ?? 'Unknown'; ?></td>
                    <td><?php echo htmlspecialchars($chat['message']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($chat['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
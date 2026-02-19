<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Website</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        nav {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
            cursor: pointer;
        }
        
        nav a:hover {
            color: #667eea;
        }
        
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        section {
            display: none;
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease;
        }
        
        section.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .rating-stars {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0;
        }
        
        .star {
            font-size: 2rem;
            cursor: pointer;
            color: #ddd;
            transition: color 0.3s;
        }
        
        .star.active,
        .star:hover {
            color: #ffd700;
        }
        
        .message {
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
            display: none;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }
        
        .chat-messages {
            height: 400px;
            overflow-y: auto;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f9f9f9;
        }
        
        .chat-message {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .chat-message small {
            color: #666;
            font-size: 0.8rem;
        }
        
        .chat-input {
            display: flex;
            gap: 0.5rem;
        }
        
        .chat-input input {
            flex: 1;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .stat-card {
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 5px;
            text-align: center;
        }
        
        .stat-card h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        
        .visitor-id {
            background: #f0f0f0;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            font-family: monospace;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a onclick="showSection('home')">Home</a></li>
            <li><a onclick="showSection('portfolio')">Portfolio</a></li>
            <li><a onclick="showSection('ratings')">Ratings</a></li>
            <li><a onclick="showSection('contact')">Contact</a></li>
            <li><a onclick="showSection('chat')">Live Chat</a></li>
        </ul>
    </nav>
    
    <main>
        <!-- Home Section -->
        <section id="home" class="active">
            <div class="container">
                <h1>Welcome to Our Interactive Website</h1>
                <p>This is a demo website that tracks visitors and allows you to interact through ratings, messages, and live chat.</p>
                <div class="visitor-info">
                    <p>Your Visitor ID: <span id="visitor-id" class="visitor-id">Loading...</span></p>
                </div>
                <div class="message" id="home-message"></div>
            </div>
        </section>
        
        <!-- Portfolio Section -->
        <section id="portfolio">
            <div class="container">
                <h1>Our Portfolio</h1>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Web Design</h3>
                        <p>Modern and responsive websites</p>
                    </div>
                    <div class="stat-card">
                        <h3>Mobile Apps</h3>
                        <p>Native and cross-platform apps</p>
                    </div>
                    <div class="stat-card">
                        <h3>UI/UX Design</h3>
                        <p>User-centered design solutions</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Ratings Section -->
        <section id="ratings">
            <div class="container">
                <h1>Rate Our Work</h1>
                <div class="rating-stars" id="rating-stars">
                    <span class="star" data-rating="1">★</span>
                    <span class="star" data-rating="2">★</span>
                    <span class="star" data-rating="3">★</span>
                    <span class="star" data-rating="4">★</span>
                    <span class="star" data-rating="5">★</span>
                </div>
                <input type="hidden" id="rating-value" value="0">
                <div class="form-group">
                    <label for="rating-comment">Comment (optional):</label>
                    <textarea id="rating-comment" placeholder="Tell us what you think..."></textarea>
                </div>
                <button onclick="submitRating()">Submit Rating</button>
                <div class="message" id="rating-message"></div>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact">
            <div class="container">
                <h1>Contact Us</h1>
                <div class="form-group">
                    <label for="contact-name">Name:</label>
                    <input type="text" id="contact-name" required>
                </div>
                <div class="form-group">
                    <label for="contact-email">Email:</label>
                    <input type="email" id="contact-email" required>
                </div>
                <div class="form-group">
                    <label for="contact-subject">Subject:</label>
                    <input type="text" id="contact-subject">
                </div>
                <div class="form-group">
                    <label for="contact-message">Message:</label>
                    <textarea id="contact-message" required></textarea>
                </div>
                <button onclick="sendMessage()">Send Message</button>
                <div class="message" id="contact-message-box"></div>
            </div>
        </section>
        
        <!-- Chat Section -->
        <section id="chat">
            <div class="container">
                <h1>Live Chat</h1>
                <div class="chat-messages" id="chat-messages"></div>
                <div class="chat-input">
                    <input type="text" id="chat-input" placeholder="Type your message...">
                    <button onclick="sendChat()">Send</button>
                </div>
            </div>
        </section>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let visitorId = null;
    
    $(document).ready(function() {
        // Track initial visit
        trackVisit('home');
        
        // Setup rating stars
        $('.star').click(function() {
            let rating = $(this).data('rating');
            $('#rating-value').val(rating);
            $('.star').removeClass('active');
            $(this).addClass('active');
            $(this).prevAll('.star').addClass('active');
        });
        
        // Setup chat enter key
        $('#chat-input').keypress(function(e) {
            if (e.which == 13) {
                sendChat();
            }
        });
        
        // Load chat messages every 3 seconds
        loadChatMessages();
        setInterval(loadChatMessages, 3000);
    });
    
    function showSection(section) {
        $('section').removeClass('active');
        $('#' + section).addClass('active');
        trackVisit(section);
    }
    
function trackVisit(section) {
    console.log('Attempting to track visit for section:', section);
    
    // Show loading state
    $('#visitor-id').text('Tracking...');
    
    $.ajax({
        url: 'ajax/handlers.php',
        method: 'POST',
        data: {
            action: 'track_visit',
            section: section
        },
        dataType: 'json',
        timeout: 10000, // 10 second timeout
        success: function(response) {
            console.log('Track visit response:', response);
            if (response && response.success) {
                visitorId = response.visitor_id;
                $('#visitor-id').text(visitorId);
                showMessage('home-message', 'Visit tracked successfully! Visitor ID: ' + visitorId, 'success');
            } else {
                const errorMsg = response && response.error ? response.error : 'Unknown error';
                $('#visitor-id').text('Error');
                showMessage('home-message', 'Error tracking visit: ' + errorMsg, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error Details:');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response Text:', xhr.responseText);
            console.error('Status Code:', xhr.status);
            
            let errorMessage = 'Error tracking visit. ';
            
            if (xhr.status === 0) {
                errorMessage += 'Network error - cannot connect to server.';
            } else if (xhr.status === 404) {
                errorMessage += 'Handler file not found (404).';
            } else if (xhr.status === 500) {
                errorMessage += 'Server error (500).';
            } else if (xhr.status === 403) {
                errorMessage += 'Access forbidden (403).';
            } else {
                errorMessage += 'Status: ' + xhr.status + ' - ' + error;
            }
            
            $('#visitor-id').text('Connection Error');
            showMessage('home-message', errorMessage, 'error');
            
            // For development, use a mock ID
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                console.log('Using mock visitor ID for development');
                visitorId = Math.floor(Math.random() * 1000) + 1000;
                $('#visitor-id').text(visitorId + ' (DEV MODE)');
                showMessage('home-message', 'Using development mode with mock ID: ' + visitorId, 'success');
            }
        }
    });
}
    function submitRating() {
        let rating = $('#rating-value').val();
        let comment = $('#rating-comment').val();
        
        if (rating == 0) {
            showMessage('rating-message', 'Please select a rating!', 'error');
            return;
        }
        
        if (!visitorId) {
            showMessage('rating-message', 'Please wait for visitor ID to be assigned!', 'error');
            return;
        }
        
        $.ajax({
            url: 'ajax/handlers.php',
            method: 'POST',
            data: {
                action: 'add_rating',
                visitor_id: visitorId,
                rating: rating,
                comment: comment
            },
            dataType: 'json',
            success: function(response) {
                console.log('Rating response:', response); // Debug log
                if (response.success) {
                    showMessage('rating-message', 'Thank you for your rating!', 'success');
                    $('#rating-value').val('0');
                    $('#rating-comment').val('');
                    $('.star').removeClass('active');
                } else {
                    showMessage('rating-message', response.error || 'Error submitting rating', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error submitting rating:', error);
                console.error('Response:', xhr.responseText);
                showMessage('rating-message', 'Error submitting rating. Check console for details.', 'error');
            }
        });
    }
    
    function sendMessage() {
        let name = $('#contact-name').val();
        let email = $('#contact-email').val();
        let subject = $('#contact-subject').val();
        let message = $('#contact-message').val();
        
        if (!name || !email || !message) {
            showMessage('contact-message-box', 'Please fill in all required fields!', 'error');
            return;
        }
        
        $.ajax({
            url: 'ajax/handlers.php',
            method: 'POST',
            data: {
                action: 'send_message',
                name: name,
                email: email,
                subject: subject,
                message: message,
                section: 'contact'
            },
            dataType: 'json',
            success: function(response) {
                console.log('Message response:', response); // Debug log
                if (response.success) {
                    showMessage('contact-message-box', 'Message sent successfully!', 'success');
                    $('#contact-name').val('');
                    $('#contact-email').val('');
                    $('#contact-subject').val('');
                    $('#contact-message').val('');
                } else {
                    showMessage('contact-message-box', response.error || 'Error sending message', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', error);
                console.error('Response:', xhr.responseText);
                showMessage('contact-message-box', 'Error sending message. Check console for details.', 'error');
            }
        });
    }
    
    function sendChat() {
        let message = $('#chat-input').val();
        
        if (!message.trim()) {
            return;
        }
        
        if (!visitorId) {
            alert('Please wait for visitor ID to be assigned!');
            return;
        }
        
        $.ajax({
            url: 'ajax/handlers.php',
            method: 'POST',
            data: {
                action: 'add_chat',
                visitor_id: visitorId,
                message: message
            },
            dataType: 'json',
            success: function(response) {
                console.log('Chat response:', response); // Debug log
                if (response.success) {
                    $('#chat-input').val('');
                    loadChatMessages();
                } else {
                    console.error('Error sending chat:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending chat:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }
    
    function loadChatMessages() {
        $.ajax({
            url: 'ajax/handlers.php',
            method: 'GET',
            data: { action: 'get_chats' },
            dataType: 'json',
            success: function(response) {
                console.log('Chat messages response:', response); // Debug log
                
                // Check if response is an array
                if (Array.isArray(response)) {
                    if (response.length === 0) {
                        $('#chat-messages').html('<div class="chat-message">No messages yet. Start the conversation!</div>');
                    } else {
                        let html = '';
                        response.forEach(function(msg) {
                            html += '<div class="chat-message">';
                            html += '<strong>Visitor ' + (msg.visitor_id || 'Unknown') + ':</strong> ';
                            html += htmlspecialchars(msg.message || '');
                            html += '<br><small>' + (msg.created_at ? new Date(msg.created_at).toLocaleString() : 'Unknown date') + '</small>';
                            html += '</div>';
                        });
                        $('#chat-messages').html(html);
                        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                    }
                } else {
                    console.error('Expected array but got:', response);
                    $('#chat-messages').html('<div class="chat-message error">Error loading messages. Please refresh the page.</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading chat messages:', error);
                console.error('Response:', xhr.responseText);
                $('#chat-messages').html('<div class="chat-message error">Error loading messages. Check console for details.</div>');
            }
        });
    }
    
    function showMessage(elementId, message, type) {
        $('#' + elementId).removeClass('success error').addClass(type).text(message).show();
        setTimeout(function() {
            $('#' + elementId).fadeOut();
        }, 3000);
    }
    
    // Helper function to prevent XSS
    function htmlspecialchars(str) {
        if (typeof str !== 'string') return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;')
                  .replace(/"/g, '&quot;')
                  .replace(/'/g, '&#039;');
    }
</script>
</body>
</html>
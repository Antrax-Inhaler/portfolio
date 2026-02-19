<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Simple Database Connection Test</h1>";

// Load .env file manually
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
    return true;
}

// Load environment variables
loadEnv(__DIR__ . '/.env');

// Get database credentials
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

echo "<h2>Configuration:</h2>";
echo "Host: " . $host . "<br>";
echo "Port: " . $port . "<br>";
echo "Database: " . $dbname . "<br>";
echo "User: " . $user . "<br>";
echo "Password: " . (empty($pass) ? 'NOT SET' : '******') . "<br>";

// Test connection
echo "<h2>Connection Test:</h2>";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database successfully!<br>";
    
    // Test query
    $result = $pdo->query("SELECT 1 as test");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "✅ Test query executed: " . $row['test'] . "<br>";
    
    // Check if ratings table exists
    $result = $pdo->query("
        SELECT EXISTS (
            SELECT FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND table_name = 'ratings'
        ) as exists
    ");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    if ($row['exists']) {
        echo "✅ Ratings table exists<br>";
    } else {
        echo "❌ Ratings table does not exist. Creating it now...<br>";
        
        // Create ratings table
        $sql = "CREATE TABLE IF NOT EXISTS ratings (
            id BIGSERIAL PRIMARY KEY,
            visitor_id BIGINT,
            rating SMALLINT CHECK (rating >= 1 AND rating <= 5),
            comment TEXT,
            created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);
        echo "✅ Ratings table created!<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "<br>";
    echo "<h3>Troubleshooting Tips:</h3>";
    echo "- Check if your IP is allowed in Supabase<br>";
    echo "- Verify password contains no special characters that need escaping<br>";
    echo "- Make sure the database user exists<br>";
}
?>
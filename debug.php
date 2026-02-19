<?php
echo "<h1>Debug Information</h1>";

// Check current directory
echo "<h2>Directory Info</h2>";
echo "Current script path: " . __DIR__ . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Check if files exist
echo "<h2>File Existence</h2>";
$files_to_check = [
    'ajax/handlers.php',
    'config/database.php',
    'includes/visitor.php',
    '.env'
];

foreach ($files_to_check as $file) {
    $full_path = __DIR__ . '/' . $file;
    if (file_exists($full_path)) {
        echo "✅ $file exists<br>";
        echo "   Path: $full_path<br>";
        echo "   Readable: " . (is_readable($full_path) ? 'Yes' : 'No') . "<br>";
    } else {
        echo "❌ $file does not exist at: $full_path<br>";
    }
}

// Check PHP extensions
echo "<h2>PHP Extensions</h2>";
$required_extensions = ['pdo_pgsql', 'pgsql', 'json'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext is loaded<br>";
    } else {
        echo "❌ $ext is NOT loaded<br>";
    }
}

// Test database connection
echo "<h2>Database Connection Test</h2>";
try {
    require_once 'config/database.php';
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "✅ Database connection successful<br>";
    
    // Test query
    $stmt = $conn->query("SELECT 1 as test");
    $result = $stmt->fetch();
    echo "✅ Test query successful: " . $result['test'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// Show .env contents (masked)
echo "<h2>.env File Check</h2>";
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    // Mask sensitive data
    $env_content = preg_replace('/(PASSWORD=).*/', '$1[REDACTED]', $env_content);
    echo "<pre>" . htmlspecialchars($env_content) . "</pre>";
} else {
    echo "❌ .env file not found<br>";
}
?>
<?php
// Method using pg_connect instead of PDO
$host = 'aws-1-ap-south-1.pooler.supabase.com';
$port = '6543';
$database = 'postgres';
$schema = 'development';
$username = 'postgres.tzmxcqguycbfyykenpvt';
$password = 'JovenAndrei#03240399';

header('Content-Type: application/json');

// Check if pg_connect is available
if (!function_exists('pg_connect')) {
    echo json_encode([
        'success' => false,
        'error' => 'PostgreSQL extension (pg_connect) is not installed. Please enable php-pgsql.'
    ], JSON_PRETTY_PRINT);
    exit;
}

try {
    // Connection string for pg_connect
    $conn_string = "host=$host port=$port dbname=$database user=$username password=$password";
    
    // Connect with error handling
    $connection = @pg_connect($conn_string);
    
    if (!$connection) {
        $error = error_get_last();
        throw new Exception($error['message'] ?? 'Connection failed');
    }
    
    // Set schema
    pg_query($connection, "SET search_path TO $schema");
    
    // Query all links
    $result = pg_query($connection, "SELECT * FROM links ORDER BY display_order, id");
    
    if (!$result) {
        throw new Exception(pg_last_error($connection));
    }
    
    // Fetch all rows
    $links = [];
    while ($row = pg_fetch_assoc($result)) {
        $links[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $links,
        'count' => count($links),
        'method' => 'pg_connect'
    ], JSON_PRETTY_PRINT);
    
    pg_close($connection);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'note' => 'Tried using pg_connect instead of PDO'
    ], JSON_PRETTY_PRINT);
}
?>
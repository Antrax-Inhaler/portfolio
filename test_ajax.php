<?php
// Simple test to check if PHP is working
echo "PHP is working!";

// Test if we can access the handler
echo "<br>Testing ajax/handlers.php:<br>";
if (file_exists('ajax/handlers.php')) {
    echo "✅ handlers.php exists";
} else {
    echo "❌ handlers.php not found";
}
?>
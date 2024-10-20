<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'handbyje_teeest');
define('DB_USER', 'handbyje_adminooo');
define('DB_PASS', 'xwH^?iPQ+x1B');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// GPT API Key
define('GPT_API_KEY', '');
?>

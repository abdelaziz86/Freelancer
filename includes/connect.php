<?php
$host = 'localhost';      // Your host (usually 'localhost' for local development)
$dbname = 'freelancer';   // Your database name
$username = 'root';  // Your MySQL username
$password = '';  // Your MySQL password

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully!";
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

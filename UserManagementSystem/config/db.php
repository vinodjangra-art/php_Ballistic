<?php 
  // Database config
$host = "localhost";
$dbname = "User_Management";
$username = "root";
$password = "phpmyadmin";  
try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p style='color:green;'>Connected successfully</p>";

} catch(PDOException $e) {
    die("<p style='color:red;'>Connection failed: " . $e->getMessage() . "</p>");
}
?>
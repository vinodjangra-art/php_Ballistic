<!DOCTYPE html>
<html>
<head>
    <title>Student Form</title>
</head>
<body>

<h2>Student Form</h2>

<form method="POST">
    ID: <input type="text" name="id"><br><br>
    Name: <input type="text" name="name"><br><br>
    Department: <input type="text" name="dept"><br><br>
    
    <input type="submit" name="submit" value="Submit">
</form>

<?php

// Database config
$host = "localhost";
$dbname = "test";
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

// When form is submitted
if(isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];

    // Validation
    if(empty($id) || empty($name) || empty($dept)) {
        echo "<p style='color:red;'>All fields are required!</p>";
    } else {

        try {
            // Prepare statement
            $stmt = $conn->prepare("INSERT INTO FormTable (id, name, dept) VALUES (:id, :name, :dept)");

            // Bind parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':dept', $dept);

            // Execute
            $stmt->execute();

            echo "<p style='color:green;'>Data inserted successfully!</p>";

        } catch(PDOException $e) {
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
}

// Close connection
$conn = null;
?>

</body>
</html>
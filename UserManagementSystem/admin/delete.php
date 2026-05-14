


<?php 
session_start();
require '../config/db.php';

//fetch id
$id = $_GET['id'];
echo $id;

try{
$stmt = $conn->prepare("UPDATE users SET score = 1 WHERE id = :id");
$stmt->bindParam(':id', $id);

$stmt->execute();

echo "<p style='color:green;'>User deleted successfully!</p>";
}
catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

  ?>

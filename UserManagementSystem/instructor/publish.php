<?php 
     session_start();
     $id = $_GET['id'];
  
     require '../config/db.php'; 
   
     $stmt = $conn->prepare("UPDATE courses SET status = 'published' WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("Location: courses.php");
   
        // header("Location: courses.php");
?>
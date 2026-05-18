<?php 
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

try {
    if(isset($_POST['courseId'])) {
        $courseId = $_POST['courseId'];
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $level = $_POST['level'] ?? '';
        
        // Update course in database
        $stmt = $conn->prepare("UPDATE courses SET title = :title, description = :description, price = :price, level = :level WHERE id = :courseId");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':courseId', $courseId);
        
        if($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Course updated successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update course'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course ID not provided'
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>

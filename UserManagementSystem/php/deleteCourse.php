
<?php 
session_start();
require_once '../config/db.php';

try {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // Fetch course details
        $stmt = $conn->prepare("UPDATE  courses SET score = 1  WHERE id = :id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    
     
            // Return course data as JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'Course deleted successfully'
            ]);
       
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
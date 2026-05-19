
<?php 
session_start();
require_once '../config/db.php';

try {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // Delete user by setting score to 1
        $stmt = $conn->prepare("UPDATE  users SET score = 1  WHERE id = :id");

        $stmt->bindParam(':id',$id);
        $stmt->execute();
    
     
            // Return user data as JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ]);
       
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'User ID not provided'
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>

<?php 
session_start();
require_once '../config/db.php';



try {
    if(isset($_POST['courseId'])) {
        $courseId = $_POST['courseId'];
        
        // Fetch course details
        $stmt = $conn->prepare("SELECT * FROM courses WHERE id = :courseId");
        $stmt->bindParam(':courseId',$courseId);
        $stmt->execute();
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($course) {
            // Return course data as JSON
            echo json_encode([
                'status' => 'success',
                'data' => $course,
                'message' => 'Course fetched successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Course not found'
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
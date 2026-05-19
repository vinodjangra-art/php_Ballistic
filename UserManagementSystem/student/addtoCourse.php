<?php 
session_start();
require '../config/db.php';

$student_id = $_SESSION['user_id'];
$course_id = $_GET['id'];    


$stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)");
$stmt->bindParam(':student_id', $student_id);
$stmt->bindParam(':course_id', $course_id);
$stmt->execute();
 
header("Location:explore.php");

?>
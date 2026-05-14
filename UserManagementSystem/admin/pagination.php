<?php
require "../config/db.php";

$page_size = 5;

// Students pagination
$stmt = $conn->prepare("SELECT COUNT(id) AS total FROM users WHERE role = 'student'");
$stmt->execute();
$total_results_students = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages_students = max(1, ceil($total_results_students / $page_size));
$page_students = isset($_GET['page_students']) ? (int)$_GET['page_students'] : 1;
$page_students = max(1, min($page_students, $total_pages_students));
$start_students = ($page_students - 1) * $page_size;
$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'student' LIMIT :start_from, :page_size");
$stmt->bindParam(':start_from', $start_students, PDO::PARAM_INT);
$stmt->bindParam(':page_size', $page_size, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Instructors pagination
$stmt = $conn->prepare("SELECT COUNT(id) AS total FROM users WHERE role = 'instructor' AND score = 0");
$stmt->execute();
$total_results_instructors = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages_instructors = max(1, ceil($total_results_instructors / $page_size));
$page_instructors = isset($_GET['page_instructors']) ? (int)$_GET['page_instructors'] : 1;
$page_instructors = max(1, min($page_instructors, $total_pages_instructors));
$start_instructors = ($page_instructors - 1) * $page_size;
$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'instructor' AND score = 0 LIMIT :start_from, :page_size");
$stmt->bindParam(':start_from', $start_instructors, PDO::PARAM_INT);
$stmt->bindParam(':page_size', $page_size, PDO::PARAM_INT);
$stmt->execute();
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
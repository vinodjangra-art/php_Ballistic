<?php
require "../config/db.php";


$page_size = 5;
$stmt = $conn->prepare("SELECT COUNT(id) AS total FROM users WHERE role = 'student'");
$stmt->execute();



$total_results = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$total_pages = ceil($total_results / $page_size);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$page  = max(1,min($page,$total_pages));

$start_from = ($page-1) * $page_size;

$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'student' LIMIT :start_from, :page_size");
$stmt->bindParam(':start_from',$start_from, PDO::PARAM_INT);
$stmt->bindParam(':page_size',$page_size, PDO::PARAM_INT);

$stmt->execute();

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
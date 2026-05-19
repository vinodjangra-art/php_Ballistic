
<?php

session_start();
require '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login.php");
  
}

// Allow only students
if ($_SESSION['role'] != 'student') {
    header("Location: ../Login.php");
   
}


// Get logged in user id
$id = $_SESSION['user_id'];

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

$student = $stmt->fetch(PDO::FETCH_ASSOC);

// If no student found
if (!$student) {
    session_destroy();
    header("Location: ../Login.php");
    exit();
}

// Fetch enrolled courses
$stmt = $conn->prepare("SELECT * FROM courses 
    JOIN enrollments ON courses.id = enrollments.course_id 
    WHERE enrollments.student_id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Student Dashboard</title>
</head>

<body class="bg-[#050C18] min-h-screen text-white">

    <!-- //navbar -->
    <div class="bg-[#0E295A] px-8 py-4 flex justify-between items-center shadow-lg">

        <h1 class="text-2xl font-bold text-[#FED50A]">
            Student Dashboard
        </h1>
          
         <div class="flex items-center justify-between gap-4">
             <a href="explore.php"
           class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition">
            Explore Courses
        </a>

        <a href="../logout.php"
           class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition">
            Logout
        </a>

         </div>
         

    </div>

    <!-- student info -->
    <div class="max-w-4xl mx-auto mt-10 bg-[#0E295A] rounded-2xl p-8 shadow-2xl">

        <!-- Profile Section -->
        <div class="flex items-center gap-8">

            <img
                src="../uploads/<?php echo $student['profile_picture']  ?>"
                alt="Profile"
                class="w-32 h-32 rounded-full border-4 border-[#FED50A] object-cover"
            >

            <div>

                <h2 class="text-3xl font-bold">
                    <?php
                    echo ($student['firstName']) . " " .
                         ($student['lastName']);
                    ?>
                </h2>

                <p class="text-[#A0A7B4] mt-2">
                    @<?php echo ($student['username']); ?>
                </p>

                <p class="text-[#57A6DA] mt-1">
                    <?php echo($student['email']); ?>
                </p>

            </div>

        </div>

        <!-- Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Address
                </h3>

                <p>
                    <?php echo ($student['address']); ?>
                </p>
            </div>

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Phone Number
                </h3>

                <p>
                    <?php echo ($student['phone']); ?>
                </p>
            </div>

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Gender
                </h3>

                <p>
                    <?php echo ($student['gender']); ?>
                </p>
            </div>

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Role
                </h3>

                <p>
                    <?php echo ($student['role']); ?>
                </p>
            </div>

        </div>

    </div>
    <div>
        <div class="flex flex-col gap-4 items-center justify-center  mt-12 mb-6 px-4">

            <h2 class="text-2xl font-bold text-[#FED50A]">
                Enrolled Courses
            </h2>

       <!-- Courses Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php if (empty($courses)): ?>
            <p class="text-center text-[#A0A7B4] col-span-full">
                You are not enrolled in any courses yet.
            </p>
        <?php else: ?>
            <?php foreach($courses as $course): ?>
                <!-- Course Card -->
                <div class="bg-[#0E295A] border border-[#215A9C] rounded-3xl overflow-hidden shadow-2xl hover:scale-[1.02] transition duration-300">

                    <!-- Thumbnail -->
                    <img
                        src="../uploads/course_thumbnails/<?php echo $course['thumbnail']; ?>"
                        alt="Course Thumbnail"
                        class="w-full h-52 object-cover"
                    >

                    <!-- Content -->
                    <div class="p-6">

                        <!-- Category -->
                        <div class="flex items-center justify-between mb-4">

                            <span class="bg-[#FED50A]/20 text-[#FED50A] text-sm font-semibold px-3 py-1 rounded-full">
                                <?php echo $course['category']; ?>
                            </span>

                            <span class="bg-green-500/20 text-green-400 text-xs px-3 py-1 rounded-full">
                                <?php echo $course['status']; ?>
                            </span>

                        </div>

                        <!-- Title -->
                        <h2 class="text-2xl font-bold text-[#ECEFF9] mb-3">
                            <?php echo $course['title']; ?>
                        </h2>

                        <!-- Description -->
                        <p class="text-[#A0A7B4] text-sm leading-6 mb-5">
                            <?php echo $course['description']; ?>
                        </p>

                        <!-- Price & Level -->
                        <div class="flex items-center justify-between mb-6">

                            <span class="text-[#57A6DA] text-xl font-bold">
                                <?php echo "$" . $course['price']; ?>
                            </span>

                            <span class="bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] text-sm px-3 py-1 rounded-lg">
                                <?php echo $course['level']; ?>
                            </span>

                        </div>
                         <a href="../errorPage.php"
       class="flex flex-center justify-center items-center bg-green-500 
       hover:brightness-110 text-[#050C18] font-bold p-10 py-3 rounded-xl transition duration-300 shadow-lg">
       
       View Details
    </a>
                    </div>
                </div>
                
            <?php endforeach; ?>
        <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>


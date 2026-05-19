<?php 
require '../config/db.php';
session_start();

$student_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT * FROM courses WHERE status = 'published'");
// $stmt->bindParam(':status', $status);
// $status = 'draft';
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Courses</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#050C18] min-h-screen px-4 py-10">

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex  items-center justify-between gap-4 mb-10">

            <div>
                <h1 class="text-4xl font-bold text-[#ECEFF9] mb-2">
                    Explore Courses
                </h1>

                <p class="text-[#A0A7B4]">
                    Discover new courses to enhance your skills.
                </p>
            </div>

            <!-- Create Button -->
            <a
                href="dashboard.php"
                class="bg-[#FED50A] hover:brightness-110 text-[#050C18] font-bold px-6 py-3 rounded-xl transition duration-300 shadow-lg"
            >
                Dashboard
            </a>

        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

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
                            <?php echo "₹" . $course['price']; ?>
                        </span>

                        <span class="bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] text-sm px-3 py-1 rounded-lg">
                            <?php echo $course['level']; ?>
                        </span>

                    </div>


                 <?php 
                        $stmt = $conn->prepare("SELECT * FROM enrollments WHERE student_id = :student_id AND course_id = :course_id");
                        $stmt->bindParam(':student_id', $student_id);
                        $stmt->bindParam(':course_id', $course['id']);
                        $stmt->execute();
                        $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);
                      
                      if($enrollment) { ?>
                        <a href="../errorPage.php"
                            class="bg-[#57A6DA] hover:brightness-110 text-[#050C18] font-bold px-6 py-3 rounded-xl transition duration-300 shadow-lg">
                            View Course
                       </a>  
                       <?php } else { ?>
                        <a href="addtoCourse.php?id=<?php echo $course['id']; ?>"
                            class="bg-[#FED50A] hover:brightness-110 text-[#050C18] font-bold px-6 py-3 rounded-xl transition duration-300 shadow-lg">
                            Enroll Now
                        </a> 
                          <?php } ?> 
                    

                </div>

            </div>
        <?php endforeach; ?>

        </div>

    </div>

</body>
</html>
<?php 
require '../config/db.php';
session_start();

$instructor_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT * FROM courses WHERE instructor_id = :instructor_id AND score = 0");
$stmt -> bindParam(':instructor_id',$instructor_id);
$stmt->execute();

$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "../script/Course.js"></script>
</head>

<body class="bg-[#050C18] min-h-screen px-4 py-10">

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">

            <div>
                <h1 class="text-4xl font-bold text-[#ECEFF9] mb-2">
                    My Courses
                </h1>

                <p class="text-[#A0A7B4]">
                    Courses created by you.
                </p>
            </div>

            <!-- Create Button -->
            <a
                href="create.php?id=<?php echo $instructor['id']; ?>""
                class="bg-[#FED50A] hover:brightness-110 text-[#050C18] font-bold px-6 py-3 rounded-xl transition duration-300 shadow-lg"
            >
                + Create Course
            </a>

        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php 
        
        foreach($courses as $course): ?>
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

                        <?php  if($course['status'] == "draft" ) { ?>

                        <a href='publish.php?id=<?php echo $course['id']?>'
                        class= "bg-[#FED50A] hover:brightness-110 text-[#050C18] font-semibold px-3 py-1 rounded-full transition duration-300 shadow-lg">
                            Publish
                                  </a>
                       <?php             } ?>
                          
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

                    <!-- Actions -->
                    <div class="flex gap-3">

                        <!-- Edit -->
                        <button class="edit-btn flex-1 bg-[#57A6DA] hover:brightness-110
                         text-white font-semibold py-3 rounded-xl transition duration-300" 
                        data-course-id="<?php echo $course['id']; ?>">
                            Edit
                        </button>

                        <!-- Delete -->
                        <button
                        data-course-id="<?php echo $course['id']; ?>"
                            class="dlt-course flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition duration-300"
                        >
                            Delete
                        </button>

                    </div>

                </div>

            </div>
        <?php endforeach; ?>


         


        </div>

    </div>

  
</body>
</html>
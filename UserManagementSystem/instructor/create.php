
<?php
session_start();
require '../config/db.php';

$message = '';
$instructor_id = $_SESSION['user_id'];
   
if(isset($_POST['create_course'])){

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $level = trim($_POST['level']);
    $status = trim($_POST['status']);

    // instructor id from session
  

    $thumbnail = '';

    if(
        empty($title) ||
        empty($description) ||
        empty($category) ||
        empty($price) ||
        empty($level) ||
        empty($status)
    ){

        $message = "<p class='text-red-400 text-center mb-4'>All fields are required!</p>";

    } else {

        try{

        
            // Thumbnail Upload
            

            if(!empty($_FILES['thumbnail']['name'])){

                $target_dir = "../uploads/course_thumbnails/";

                if(!is_dir($target_dir)){
                    mkdir($target_dir, 0777, true);
                }

                $file_name = time() . '_' . basename($_FILES['thumbnail']['name']);

                $target_file = $target_dir . $file_name;

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

                if(!in_array($imageFileType, $allowed_types)){

                    die("Only JPG, JPEG, PNG & GIF files are allowed.");
                }

                if($_FILES['thumbnail']['size'] > 5000000){

                    die("Thumbnail size too large.");
                }

                if(move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)){

                    $thumbnail = $file_name;
                }
            }

          
            // Insert Course
     

            $stmt = $conn->prepare("INSERT INTO courses(
                instructor_id,
                title,
                description,
                category,
                thumbnail,
                price,
                level,
                status
            ) VALUES(
                :instructor_id,
                :title,
                :description,
                :category,
                :thumbnail,
                :price,
                :level,
                :status
            )");


            $stmt->bindParam(':instructor_id', $instructor_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':thumbnail', $thumbnail);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':level', $level);
            $stmt->bindParam(':status', $status);

            $stmt->execute();

            header("Location: courses.php");

        } catch(PDOException $e){

            $message = "<p class='text-red-400 text-center mb-4'>" . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#050C18] min-h-screen py-10 px-4">

    <div class="max-w-3xl mx-auto bg-[#0E295A] border border-[#215A9C] rounded-3xl shadow-2xl p-8">

        <!-- Heading -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-[#ECEFF9] mb-2">
                Create New Course
            </h1>

            <p class="text-[#A0A7B4]">
                Add a new course for students.
            </p>
        </div>

        <!-- Message -->
        <?php echo $message; ?>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="space-y-6">

            <!-- Course Title -->
            <div>
                <label class="block text-[#ECEFF9] mb-2 font-semibold">
                    Course Title
                </label>

                <input
                    type="text"
                    name="title"
                    placeholder="Enter course title"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Description -->
            <div>
                <label class="block text-[#ECEFF9] mb-2 font-semibold">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    placeholder="Write course description"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                ></textarea>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[#ECEFF9] mb-2 font-semibold">
                    Category
                </label>

                <input
                    type="text"
                    name="category"
                    placeholder="Web Development"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Price & Level -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-[#ECEFF9] mb-2 font-semibold">
                        Price
                    </label>

                    <input
                        type="number"
                        name="price"
                        placeholder="99"
                        class="w-full bg-[#050C18] border border-[#4A4D53] text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                    >
                </div>

                <div>
                    <label class="block text-[#ECEFF9] mb-2 font-semibold">
                        Level
                    </label>

                    <select
                        name="level"
                        class="w-full bg-[#050C18] border border-[#4A4D53] text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                    >
                        <option value="">Choose Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-[#ECEFF9] mb-2 font-semibold">
                    Course Status
                </label>

                <select
                    name="status"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
                    <option value="">Choose Status</option>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-[#ECEFF9] mb-2 font-semibold">
                    Course Thumbnail
                </label>

                <input
                    type="file"
                    name="thumbnail"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#A0A7B4] rounded-xl px-4 py-3"
                >
            </div>

            <!-- Submit -->
            <button
                type="submit"
                name="create_course"
                class="w-full bg-[#FED50A] hover:brightness-110 text-[#050C18] font-bold py-4 rounded-xl transition duration-300 shadow-lg"
            >
                Create Course
            </button>

        </form>

    </div>

</body>
</html>
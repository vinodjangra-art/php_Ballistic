
<?php

session_start();
require '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login.php");
    exit();
}

// Allow only students
if ($_SESSION['role'] != 'student') {
    header("Location: ../Login.php");
    exit();
}

// Get logged in user id
$id = $_SESSION['user_id'];

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

$student = $stmt->fetch(PDO::FETCH_ASSOC);

// If no student found

// echo $student;
//     foreach($student as $key => $value){
//         echo "$key: $value <br>";
//     }

if (!$student) {
    session_destroy();
    header("Location: ../Login.php");
    exit();
}
   
   
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

        <a href="../logout.php"
           class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition">
            Logout
        </a>

    </div>

    <!-- student info -->
    <div class="max-w-4xl mx-auto mt-10 bg-[#0E295A] rounded-2xl p-8 shadow-2xl">

        <!-- Profile Section -->
        <div class="flex items-center gap-8">

            <img
                src="../uploads/student.png"
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

</body>
</html>


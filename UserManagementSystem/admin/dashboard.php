
<?php

session_start();
require 'pagination.php';
require '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login.php");
    exit();
}

// Allow only admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../Login.php");
    exit();
}

// Get logged in user id
$id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id ");
$stmt->bindParam(':id', $id);
$stmt->execute();

$admin = $stmt->fetch(PDO::FETCH_ASSOC);


   



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "../script/User.js"></script>

    <title>Admin Dashboard</title>
</head>

<body class="bg-[#050C18] min-h-screen text-white">

    <!-- //navbar -->
    <div class="bg-[#0E295A] px-8 py-4 flex justify-between items-center shadow-lg">

        <h1 class="text-2xl font-bold text-[#FED50A]">
            Admin Dashboard
        </h1>

        <div class="flex gap-4" >
        <a  
           class="add-user cursor-pointer bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition">
            Add User
        </a>
        <a href="../logout.php"
           class="bg-red-500 cursor-pointer px-4 py-2 rounded-lg hover:bg-red-600 transition">
            Logout
        </a>

        </div>
        
    </div>

    <!-- Admin info -->
    <div class=" mx-auto mt-10 bg-[#0E295A] rounded-2xl p-8 shadow-2xl">

        <!-- Profile Section -->
        <div class="flex items-center gap-8">

            <img
                src="../uploads/admin.png"
                alt="Profile"
                class="w-32 h-32 rounded-full border-4 border-[#FED50A] object-cover"
            >

            <div>

                <h2 class="text-3xl font-bold">
                    <?php
                    echo ($admin['firstName']) . " " .
                         ($admin['lastName']);
                    ?>
                </h2>S

                <p class="text-[#A0A7B4] mt-2">
                    @<?php echo ($admin['username']); ?>
                </p>

                <p class="text-[#57A6DA] mt-1">
                    <?php echo($admin['email']); ?>
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
                    <?php echo ($admin['address']); ?>
                </p>
            </div>

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Phone Number
                </h3>

                <p>
                    <?php echo ($admin['phone']); ?>
                </p>
            </div>

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Gender
                </h3>

                <p>
                    <?php echo ($admin['gender']); ?>
                </p>
            </div>

            <div class="bg-[#050C18] p-5 rounded-xl">
                <h3 class="text-[#FED50A] font-semibold mb-2">
                    Role
                </h3>

                <p>
                    <?php echo ($admin['role']); ?>
                </p>
            </div>

        </div>
    </div>
    <!-- instructors list -->
      <div class="flex items-center justify-center mt-10 text-2xl font-bold text-[#FED50A]">
            Instructors List
        </div>

        <div>



<table class="w-full  border-collapse border border-gray-300 text-center">

    <tr class="text-[#FED50A] ">
        <th class="p-3 border">ID</th>
        <th class="p-3 border">First Name</th>
        <th class="p-3 border">Last Name</th>
        <th class="p-3 border">Email</th>
        <th class="p-3 border">Phone</th>
        <th class="p-3 border">Address</th>
        <th class="p-3 border">Gender</th>
        <th class="p-3 border">Actions</th>
        
    </tr>

    <?php 
    $i = 1;
    foreach ($instructors as $instructor) { ?>
        <tr class="">

            <td class="p-3 border">
                <?php echo $i++; ?>
            </td>

            <td class="p-3 border">
                <?php echo $instructor['firstName']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $instructor['lastName']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $instructor['email']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $instructor['phone']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $instructor['address']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $instructor['gender']; ?>
            </td>

            <td class="flex flex-col p-3 border items-center justify-center gap-1">
                
                <!-- Edit Button -->
               <a href="" data-user-id="<?php echo $instructor['id']; ?>" 
                   class=" edit-btn bg-blue-500 w-full mx-auto text-white px-3 py-1 rounded hover:bg-blue-600">
                    Edit
                </a>

                <!-- Delete Button -->
                <a href="delete.php?id=<?php echo $instructor['id']; ?>"
                   class="bg-red-500 w-full text-white px-3 py-1 rounded hover:bg-red-600 ml-2"
                   onclick="return confirm('Are you sure you want to delete this instructor?')">
                    Delete
                </a>

            </td>

        </tr>
    <?php } ?>

</table>

        <div class="flex justify-center gap-2 mt-4 mx-auto w-full max-w-md">
            <a href="?page_instructors=<?php echo max(1, $page_instructors - 1); ?>&page_students=<?php echo $page_students; ?>"
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-l hover:bg-gray-400">Prev</a>
            <p class="bg-gray-300 text-gray-700 px-4 py-2">
                Page <?php echo $page_instructors; ?> of <?php echo $total_pages_instructors; ?>
            </p>
            <a href="?page_instructors=<?php echo min($total_pages_instructors, $page_instructors + 1); ?>&page_students=<?php echo $page_students; ?>"
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-r hover:bg-gray-400">Next</a>
        </div>

        </div>


             <!-- students list -->
      <div class="flex items-center justify-center mt-10 text-2xl font-bold text-[#FED50A]">
            Students List
        </div>
         <div>



<table class="w-full  border-collapse border border-gray-300 text-center">

    <tr class="text-[#FED50A] ">
        <th class="p-3 border">ID</th>
        <th class="p-3 border">First Name</th>
        <th class="p-3 border">Last Name</th>
        <th class="p-3 border">Email</th>
        <th class="p-3 border">Phone</th>
        <th class="p-3 border">Address</th>
        <th class="p-3 border">Gender</th>
        <th class="p-3 border">Actions</th>
    </tr>

    <?php
     $i = 1;
     foreach ($students as $student) { ?>
        <tr class="">

            <td class="p-3 border">
                <?php echo $i++; ?>
            </td>

            <td class="p-3 border">
                <?php echo $student['firstName']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $student['lastName']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $student['email']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $student['phone']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $student['address']; ?>
            </td>

            <td class="p-3 border">
                <?php echo $student['gender']; ?>
            </td>

            <td class="flex flex-col p-3 border items-center justify-center gap-1">
                
                <!-- Edit Button -->
                <a href="" data-user-id="<?php echo $student['id']; ?>" 
                   class=" edit-btn bg-blue-500 w-full mx-auto text-white px-3 py-1 rounded hover:bg-blue-600">
                    Edit
                </a>

                <!-- Delete Button -->
                <a 
                   class="dlt-user bg-red-500 w-full text-white px-3 py-1 rounded hover:bg-red-600 ml-2"
                   data-user-id="<?php echo $student['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this student?')">
                    Delete
                </a>

            </td>

        </tr>
    <?php } ?>

</table>

        </div>
         <!-- pagination bar -->
        <div class="flex justify-center gap-2 mt-4 mx-auto w-full max-w-md">
            <a href="?page_instructors=<?php echo $page_instructors; ?>&page_students=<?php echo max(1, $page_students - 1); ?>"
             class="bg-gray-300 text-gray-700 px-4 py-2 rounded-l hover:bg-gray-400">Prev</a>
             <p class="bg-gray-300 text-gray-700 px-4 py-2">
                 Page <?php echo $page_students; ?> of <?php echo $total_pages_students; ?>
             </p>
            <a href="?page_instructors=<?php echo $page_instructors; ?>&page_students=<?php echo min($total_pages_students, $page_students + 1); ?>"
             class="bg-gray-300 text-gray-700 px-4 py-2 rounded-r hover:bg-gray-400">Next</a>
        </div>
    

</body>
</html>

<?php
require 'config/db.php';

if (isset($_POST['submit'])) {

    $role = $_POST['user_type'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $address = trim($_POST['address']);
    $phone_number = trim($_POST['phone_number']);
    $gender = $_POST['gender'];

    $profile_picture = '';

    // Validation
    if (
        empty($first_name) || empty($last_name) ||
        empty($email) || empty($username) ||
        empty($_POST['password']) || empty($address) ||
        empty($phone_number) || empty($gender)
    ) {

        echo "<p style='color:red;'>All fields are required!</p>";

    } else {

        try {

            // =========================
            // FILE UPLOAD START
            // =========================

            $folder="";
            if(!empty($_FILES['profile_picture']["name"])){
                  $image_name = $_FILES['profile_picture']["name"];
                  $tmp_name = $_FILES['profile_picture']['tmp_name'];
                  $file_size = $_FILES["profile_picture"]['size'];

                  $folder=basename($image_name);
                  $target_file= "uploads/" . $folder;

                  move_uploaded_file($tmp_name,$target_file);
                
            }

            // =========================
            // INSERT USER
            // =========================

            $stmt = $conn->prepare("
                INSERT INTO users(
                    role,
                    firstName,
                    lastName,
                    email,
                    username,
                    password,
                    address,
                    phone,
                    gender,
                    profile_picture
                )
                VALUES(
                    :role,
                    :firstName,
                    :lastName,
                    :email,
                    :username,
                    :password,
                    :address,
                    :phone,
                    :gender,
                    :profile_picture
                )
            ");

            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':firstName', $first_name);
            $stmt->bindParam(':lastName', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone', $phone_number);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':profile_picture', $folder);

            $stmt->execute();

            echo "<p style='color:green;'>Registered Successfully!</p>";

        } catch (PDOException $e) {

            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Register Form</title>
</head>

<body class="bg-[#050C18] min-h-screen flex items-center justify-center px-4">

    <!-- Form Container -->
    <div class="w-full max-w-md bg-[#0E295A] rounded-2xl shadow-2xl border border-[#215A9C] p-8">

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-center text-[#ECEFF9] mb-8">
            Register Form
        </h1>

        <form method="POST" enctype="multipart/form-data" action="register.php" class="space-y-5">

            <!-- User Type -->
            <div>
                <label class="block text-[#ECEFF9] font-semibold mb-2">
                    User Type
                </label>

                <div class="flex gap-6 bg-[#050C18] border border-[#4A4D53] rounded-xl p-4 text-[#ECEFF9]">

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="radio"
                            name="user_type"
                            value="student"
                            checked
                            class="accent-[#FED50A]"
                        >
                        Student
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="radio"
                            name="user_type"
                            value="instructor"
                            class="accent-[#FED50A]"
                        >
                        Instructor
                    </label>

                </div>
            </div>

            <!-- First Name -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    First Name
                </label>

                <input
                    type="text"
                    name="first_name"
                    placeholder="Enter first name"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Last Name
                </label>

                <input
                    type="text"
                    name="last_name"
                    placeholder="Enter last name"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="example@gmail.com"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>
             <!-- Username -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter username"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Password -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Address -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Address
                </label>

                <input
                    type="text"
                    name="address"
                    placeholder="Enter your address"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Phone Number -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Phone Number
                </label>

                <input
                    type="text"
                    name="phone_number"
                    placeholder="Enter your phone number"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Profile Picture -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Profile Picture
                </label>

                <input
                    type="file"
                    name="profile_picture"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#9BA2A6] rounded-xl px-4 py-3"
                >
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Gender
                </label>

                <select
                    name="gender"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
                    <option value="">-- Please choose an option --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                name="submit"
                class="w-full bg-[#FED50A] hover:brightness-110 text-[#050C18] font-bold py-3 rounded-xl transition duration-300 shadow-lg"
            >
                Register
            </button>

        </form>

    </div>

   



</body>
</html>
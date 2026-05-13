<?php 
session_start();
$role = $_SESSION['role'];
echo $role;
if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'student') {
        header("Location: student/dashboard.php");
        exit();
    }

    elseif ($_SESSION['role'] == 'instructor') {
        header("Location: instructor/dashboard.php");
        exit();
    }
    else {
        header("Location: admin/dashboard.php");

    }
}

require 'config/db.php';
if(isset($_POST['login'])) {

$username = $_POST['username'];
$password = $_POST['password'];

try{
    $stmt = $conn->prepare("SELECT * FROM users 
    WHERE username = :username OR email = :username");
    $stmt->bindParam(':username', $username);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user){
        echo "<p style='color:red;'>User not found!</p>";
    }

    else if(password_verify($password, $user['password'])){
       

    // Store session data
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if($user['role'] == 'admin'){

        header("Location: admin/dashboard.php");

    }

    elseif($user['role'] == 'student'){

        header("Location: student/dashboard.php");

    }

    elseif($user['role'] == 'instructor'){

        header("Location: instructor/dashboard.php");

    }

    exit;

}
    else{
        echo "<p style='color:red;'>Incorrect password!</p>";
    }

   

}


catch(PDOException $e){
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";

}
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
     <script src="https://cdn.tailwindcss.com"></script>
</head>
<body >
    <div class="bg-[#050C18] min-h-screen flex items-center justify-center px-4">
<div class = "flex flex-col gap-4 " >
        <h1 class="text-3xl font-bold text-center text-[#ECEFF9] mb-8">
            Login Form
        </h1>

        <form method = "POST" 
        class="flex flex-col gap-4 bg-[#0E295A] rounded-2xl shadow-2xl border border-[#215A9C] p-8"
         action="Login.php">
         
        <div >
            <label for="" class="text-semibold text-white">UserName/Email: </label>
            <br>
            <input type="text" name="username" placeholder="Enter username or email"
            name="username"
           class="flex gap-2 items-center rounded-xl p-4 text-[#ECEFF9] bg-[#050C18] border border-[#4A4D53] border-[#4A4D53]">
        </div>

          <div >
            <label for="" class="text-semibold text-white">Password:</label>
            <br>
            <input type="password" 
            name="password"
             placeholder="Enter your password"

            class="flex gap-2 items-center rounded-xl p-4 text-[#ECEFF9] bg-[#050C18] border border-[#4A4D53] border-[#4A4D53]">
        </div>

        <button type="submit" name="login" class="bg-[#FED50A] text-[#050C18] font-bold py-3 px-4 rounded-xl hover:bg-[#e0c100] focus:outline-none focus:ring-2 focus:ring-[#57A6DA]">
            Login
        </button>

</form>
    </div>
    </div>
    
</body>
</html>
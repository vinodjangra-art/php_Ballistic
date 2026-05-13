
<?php 
session_start();
require '../config/db.php';

//fetch id
$id = $_GET['id'];
echo $id;





$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone_number'];
   


    try{
      $stmt = $conn->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email, username=:username
      ,gender=:gender, address=:address, phone=:phone WHERE id=:id");
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $id);
        print_r($firstName);
        print_r($lastName);
        print_r($email);
        print_r($username);
        print_r($gender);
        print_r($address);
        print_r($phone);
        print_r($id);

        die();
        $stmt->execute();

        echo "<p style='color:green;'>User updated successfully!</p>";

    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Edit User</title>
</head>

<body class="bg-[#050C18] min-h-screen flex items-center justify-center px-4">


    <!-- Form Container -->
    <div class="w-full max-w-md bg-[#0E295A] rounded-2xl shadow-2xl border border-[#215A9C] p-8">

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-center text-[#FED50A] mb-8">
            Edit User
        </h1>

        <form method="POST" enctype="multipart/form-data" action="edit.php" class="space-y-5">

            

            <!-- First Name -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    First Name
                </label>

                <input
                value="<?php  echo $user['firstName'] ?>"
                    type="text"
                    name="first_name"
                    placeholder="Enter first name"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
           
</input>
            </div>
        
            <!-- Last Name -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Last Name
                </label>

                <input
                value = "<?php  echo $user['lastName'] ?>"
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
                 value = "<?php  echo $user['email'] ?>"
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
                     value = "<?php  echo $user['username'] ?>"
                    type="text"
                    name="username"
                    placeholder="Enter username"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >

</input>
            </div>

            

            <!-- Address -->
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Address
                </label>

                <input
                  value = "<?php  echo $user['address'] ?>"
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
                value = "<?php  echo $user['phone'] ?>"
                    type="text"
                    name="phone_number"
                    placeholder="Enter your phone number"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#ECEFF9] placeholder-[#A0A7B4] rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#57A6DA]"
                >
            </div>

            <!-- Profile Picture
            <div>
                <label class="block text-[#ECEFF9] mb-2">
                    Profile Picture
                </label>

                <input
                    type="file"
                    name="profile_picture"
                    class="w-full bg-[#050C18] border border-[#4A4D53] text-[#9BA2A6] rounded-xl px-4 py-3"
                >
            </div> -->

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

            <option value="male"  <?php if($user['gender'] == "Male") echo "selected" ;?> >
            Male</option>
                    <option <?php 
                    if($user['gender']=="Female") echo "selected" ?> value="female">Female</option>
                    <option <?php 
                    
                    if($user['gender']=="Other") echo "selected" ?> value="other">Other</option>
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
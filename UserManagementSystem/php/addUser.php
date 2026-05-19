<?php 

session_start();
require_once '../config/db.php';


try {

if(isset($_POST['action']) && $_POST['action'] === 'add') {
    // Return empty user object for new user form
    echo json_encode([
        'status' => 'success',
        'message' => 'Ready to add new user'
    ]);
}
elseif(isset($_POST['action']) && $_POST['action'] === 'create') {
    // Handle actual user creation
   
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
        $role = $_POST['role'] ?? 'student';

        if(empty($firstName) || empty($lastName) || empty($email) || empty($username)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Required fields are missing'
            ]);
            exit;
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email already exists'
            ]);
            exit;
        }
            // FILE UPLOAD START
            $folder="";
            if(!empty($_FILES['profile_picture']["name"])){
                $image_name = $_FILES['profile_picture']["name"];
                $tmp_name = $_FILES['profile_picture']['tmp_name'];

                $file_size = $_FILES["profile_picture"]['size'];

                $folder=basename($image_name);
                $target_file= "../uploads/" . $folder;

                
                
                if(move_uploaded_file($tmp_name,$target_file)){
                    // Insert new user
                    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, phone, address, gender, username, password, role, profile_picture) 
                    VALUES (:firstName, :lastName, :email, :phone, :address, :gender, :username, :password, :role, :profile_picture)");
                    $stmt->bindParam(':firstName', $firstName);
                    $stmt->bindParam(':lastName', $lastName);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phone', $phone);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':role', $role);
                    $stmt->bindParam(':profile_picture', $folder);
                    $stmt->execute();
                }
                  
            }
        


        echo json_encode([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);

}
else{
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid action'
    ]);
}
}

catch(PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }



?>
<?php 

session_start();
require '../config/db.php';
try {
    if(isset($_POST['userId'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];

        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $userId = $_POST['userId'];
        
        // Fetch user details
        $stmt = $conn->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, phone = :phone, address = :address, gender = :gender WHERE id = :userId");
        $stmt->bindParam(':userId',$userId);
        $stmt->bindParam(':firstName',$firstName);
        $stmt->bindParam(':lastName',$lastName);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':gender',$gender);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Return user data as JSON
            echo json_encode([
                'status' => 'success',
                'data' => $user,
                'message' => 'User updated successfully'
            ]);
        
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update user'
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

?>
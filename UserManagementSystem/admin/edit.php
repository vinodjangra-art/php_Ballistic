
<?php 
session_start();
require '../config/db.php';
//
   try{

   
   if(isset($_POST['userId'])){
    $id = $_POST['userId'];
      
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user){
        echo json_encode([
             'status' => 'success',
             'data' => $user,
             'message' => "User fetched successfully",
        ]);

    }
    else{
        echo json_encode([
             'status' => 'error',
             'message' => "User fetching Unsuccessfull",
        ]);
    }

   }
   else{
 echo json_encode([
             'status' => 'error',
             'message' => "UserId not provided",
        ]);
   }
   }
   catch(PDOException $e){
      echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
   }


  


// if(isset($_POST['submit'])){

//     $firstName = $_POST['first_name'];
//     $lastName = $_POST['last_name'];
//     $email = $_POST['email'];
//     $username = $_POST['username'];
//     $gender = $_POST['gender'];
//     $address = $_POST['address'];
//     $phone = $_POST['phone_number'];
   


//     try{
//       $stmt = $conn->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email, username=:username
//       ,gender=:gender, address=:address, phone=:phone WHERE id=:id");
//         $stmt->bindParam(':firstName', $firstName);
//         $stmt->bindParam(':lastName', $lastName);
//         $stmt->bindParam(':email', $email);
//         $stmt->bindParam(':username', $username);
//         $stmt->bindParam(':gender', $gender);
//         $stmt->bindParam(':address', $address);
//         $stmt->bindParam(':phone', $phone);
//         $stmt->bindParam(':id', $id);                                                   
//         $stmt->execute();

//         echo "<p style='color:green;'>User updated successfully!</p>";
//          header("Location: dashboard.php");

//     }
//     catch(PDOException $e){
//         echo "Error: " . $e->getMessage();
//     }

// }

// ?>

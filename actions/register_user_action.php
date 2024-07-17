<?php
  include '../settings/connection.php';

  if(isset($_POST['register']))
  {
    //Retrieve form data     
    $firstName = $_POST["firstName"]; 
    $lastName = $_POST["lastName"];                                              
    $email = $_POST["email"]; 
    $contact = $_POST["contact"];
    $password = $_POST["password"]; 
    $role = $_POST["role"]; // Fetch selected role      

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 // Check if email is already in use
 $sql = "SELECT email FROM patient WHERE email = ?";
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("s", $email);
 $stmt->execute();
 $stmt->store_result();

 if ($stmt->num_rows > 0) {
     $stmt->close();
     // header('Location: ../index.php?error=Email already exists. Please use another one.');
     echo "<script>
     alert('Email already exists. Please use another one or login in the next page');
     window.location.href='../index.php?error'
     </script>";
     // exit();
 }

 $stmt->close();

 $sql = "INSERT INTO patient (firstname, lastname, email, contact, password) VALUES ('$firstName', '$lastName', '$email','$contact','$hashedPassword')";

 $result = $conn->query($sql);


 if ($result) {
     echo "Sucessful Registration";
     header('Location:../index.php?msg=sucess');
     exit();
 } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
 }
} else {
 // If form is not submitted, redirect to register view page or take appropriate action
 echo 'error';
 header('Location:../admin/register.php?msg=error');
 exit();
}

// Close the connection
$conn->close();
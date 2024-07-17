<?php
include '../settings/connection.php';

if (isset($_POST['register'])) {
    // Retrieve form data
    $firstName = $_POST["firstName"]; 
    $lastName = $_POST["lastName"];                                              
    $email = $_POST["email"]; 
    $contact = $_POST["contact"];
    $password = $_POST["password"]; 
    $role = $_POST["role"]; // Fetch selected role

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email is already in use
    $sql = "SELECT email FROM patient WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo "<script>
        alert('Email already exists. Please use another one or login in the next page');
        window.location.href='../index.php?error'
        </script>";
    } else {
        $stmt->close();

        // Insert into the database
        $sql = "INSERT INTO patient (firstname, lastname, email, contact, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $contact, $hashedPassword, $role);
        $result = $stmt->execute();

        if ($result) {
            echo "<script>
            alert('Successful Registration');
            window.location.href='../index.php?msg=success'
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "<script>
    alert('Error: Form not submitted correctly');
    window.location.href='../admin/register.php?msg=error'
    </script>";
}

// Close the connection
$conn->close();

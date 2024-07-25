<?php
include '../settings/connection.php';

if (isset($_POST['register'])) {
    // Retrieve form data
    $firstName = $_POST["firstName"]; 
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>
        alert('Passwords do not match. Please try again.');
        window.location.href='../login/register.html?error=passwords_do_not_match';
        </script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email is already in use
    $sql = "SELECT email FROM gamer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo "<script>
        alert('Email already exists. Please use another one or login in the next page');
        window.location.href='../index.php?error=email_exists';
        </script>";
    } else {
        $stmt->close();

        // Insert into the database
        $sql = "INSERT INTO gamer (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
        $result = $stmt->execute();

        if ($result) {
            echo "<script>
            alert('Successful Registration');
            window.location.href='../index.php?msg=success';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "<script>
    alert('Error: Form not submitted correctly');
    window.location.href='../login/register.html?msg=error';
    </script>";
}

// Close the connection
$conn->close();

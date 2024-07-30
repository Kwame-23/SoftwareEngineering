<?php
include("../settings/connection.php");

if (isset($_POST["signin-btn"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $passwd = $_POST["password"];

    if (empty($email) || empty($passwd)) {
        header("Location: ../login/login.php?msg=Please fill in all required fields.");
        exit();
    }

    $sql_query = "SELECT * FROM gamer WHERE email = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($passwd, $row['password'])) {
            // Start session and set session variables
            session_start();
            $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the primary key in the 'gamer' table
            $_SESSION['email'] = $row['email'];
            $_SESSION['firstName'] = $row['firstname']; // Store user's first name in session

            header("Location: ../view/blank.php");
            exit();
        } else {
            header("Location: ../login/login.php?error=Invalid email or password.");
            exit();
        }
    } else {
        header("Location: ../login/login.php?error=Invalid email or password.");
        exit();
    }
} else {
    header("Location: ../login/login.php?error=An error occurred. Please try again.");
    die();
}




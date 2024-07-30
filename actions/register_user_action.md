
<head>
  <!-- Include SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Include SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../settings/connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    // Retrieve form data
    $firstName = $_POST["firstName"]; 
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Passwords do not match';
        echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '" . htmlspecialchars($_SESSION['error'], ENT_QUOTES) . "',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '../login/register.php';
          }
        });
        </script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email is already in use
    $sql = "SELECT email FROM gamer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
        echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '" . htmlspecialchars($_SESSION['error'], ENT_QUOTES) . "',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '../login/register.php';
          }
        });
        </script>";
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['error'] = 'Email already exists';
        echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '" . htmlspecialchars($_SESSION['error'], ENT_QUOTES) . "',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '../login/register.php';
          }
        });
        </script>";
        exit();
    } else {
        $stmt->close();

        // Insert into the database
        $sql = "INSERT INTO gamer (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $_SESSION['error'] = 'Database error: ' . $conn->error;
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: '" . htmlspecialchars($_SESSION['error'], ENT_QUOTES) . "',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../login/register.php';
              }
            });
            </script>";
            exit();
        }

        $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
        $result = $stmt->execute();

        if ($result) {
          echo 'Registeration successful';
            $_SESSION['success'] = 'Registration successful';
            echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: '" . htmlspecialchars($_SESSION['success'], ENT_QUOTES) . "',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../login/login.php';
              }
            });
            </script>";
            exit();
        } else {
            $_SESSION['error'] = 'Registration failed: ' . $stmt->error;
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: '" . htmlspecialchars($_SESSION['error'], ENT_QUOTES) . "',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '../login/register.php';
              }
            });
            </script>";
            exit();
        }

        $stmt->close();
    }
} else {
    $_SESSION['error'] = 'Form not submitted correctly';
    echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: '" . htmlspecialchars($_SESSION['error'], ENT_QUOTES) . "',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '../login/register.php';
      }
    });
    </script>";
    exit();
}

$conn->close();
?>

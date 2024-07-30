<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/logins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../img/gamelogo.png" width="450" height="auto">
        </div>
        <form action="../actions/login_user_action.php" method="post">
            <input type="text" name="email" placeholder="Enter your email" class="input-field" required>
            <input type="password" name="password" placeholder="Enter your password" class="input-field" required>
            <div class="button-container">
                <p style="text-decoration: underline;">Pick your sign</p>
                <hr class="separator">
                <button type="button" class="button"><i class="fas fa-times"></i></button>
                <button type="button" class="button"><i class="fas fa-circle"></i></button><br>
                <hr class="separator">
                <button type="submit" name="signin-btn">Login!</button>
                <p>Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </form>
    </div>
</body>
</html>



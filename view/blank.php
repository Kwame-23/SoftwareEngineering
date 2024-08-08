<!-- blank.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            opacity: 0; /* initial opacity is 0 */
            transition: opacity 1s;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <img src="../img/gamelogo.png" alt="">
    <script>
        // Fade in
        document.body.style.opacity = 1;

        // Fade out and redirect to home.php after 5 seconds
        setTimeout(() => {
            document.body.style.opacity = 0;
            setTimeout(() => {
                window.location.href = '../index.php';
            }, 1000); // wait for the fade-out animation to complete
        }, 1000);
    </script>
</body>
</html>
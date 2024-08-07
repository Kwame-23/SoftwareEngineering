<?php
include_once '../env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // API response
    $api_response = '{
        "email": "tiffanydegbotse123@gmail.com",
        "autocorrect": "",
        "deliverability": "DELIVERABLE",
        "quality_score": "0.95",
        "is_valid_format": {
            "value": true,
            "text": "TRUE"
        },
        "is_free_email": {
            "value": true,
            "text": "TRUE"
        },
        "is_disposable_email": {
            "value": false,
            "text": "FALSE"
        },
        "is_role_email": {
            "value": false,
            "text": "FALSE"
        },
        "is_catchall_email": {
            "value": false,
            "text": "FALSE"
        },
        "is_mx_found": {
            "value": true,
            "text": "TRUE"
        },
        "is_smtp_valid": {
            "value": true,
            "text": "TRUE"
        }
    }';

    // Convert JSON response to associative array
    $api_response = json_decode($api_response, true);

    // Check if email is valid and deliverable
    if ($api_response['is_valid_format']['value'] && $api_response['is_mx_found']['value'] && $api_response['is_smtp_valid']['value']) {
        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings for Gmail SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = USERNAME; // Your Gmail email address
            $mail->Password = PASSWD; // Your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($email, $first_name . ' ' . $last_name);
            $mail->addAddress(USERNAME);

            // Content
            $mail->isHTML(false);
            $mail->Subject = 'New Message from Contact Form';
            $mail->Body = "First Name: $first_name\nLast Name: $last_name\nEmail: $email\nMessage:\n$message";

            // Send email
            $mail->send();

            // return true;
            echo "<script>
                alert('Your message has been sent successfully')
                window.location.href='../view/contact_page.php'
            </script>";
        
        } catch (Exception $e) {
            echo "Failed to send the message. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid email address or not deliverable.";
    }
} else {
    echo "Invalid request method.";
}


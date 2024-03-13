<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

// Function to send email
function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Outlook SMTP server
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'ameeshagamage@outlook.com'; // Your Outlook email address
    $mail->Password = 'ameesha12345'; // Your Outlook password
    $mail->SMTPSecure = 'tls';

    $mail->setFrom('ameeshagamage@outlook.com', 'Admin'); // Sender's email address and name
    $mail->addAddress($to); // Recipient's email address

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
}

// Check if approve button is clicked
if (isset($_POST['approve'])) {
    $studentId = $_POST['student_id']; // Assuming you have a hidden input field with name "student_id" in your form
    $to = $_POST['student_email']; // Assuming you have a hidden input field with name "student_email" in your form
    $subject = 'Approval Notification';
    $message = 'congratulations! Your application has been approved. Congratulations!'; // Customize the message as needed

    // Send email
    if (sendEmail($to, $subject, $message)) {
        echo '<script>alert("Email sent successfully.");</script>';
    } else {
        echo '<script>alert("Failed to send email. Please try again later.");</script>';
    }
}
?>

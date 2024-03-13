<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

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
    $to = $_POST['student_email'];
    $property = $_POST['property_name']; // Assuming you have a hidden input field with name "student_email" in your form
    $subject = 'Approval Notification';
   $message = "
    <html>
    <head>
        <title>Approval Notification</title>
    </head>
    <body>
        <p>Dear $studentName,</p>
        <p>We are pleased to inform you that your application has been approved.</p>
        <p>in <b>$property<b></p>
        <p>If you have any questions or need further assistance, please feel free to contact us.</p>
        <p>Best regards,<br>
        Dormitory_Discover<br>
        Admin<br>
    
    </body>
    </html>"; // Message includes student's name

    // Send email
    if (sendEmail($to, $subject, $message)) {
        echo '<script>alert("Email sent successfully.");</script>';
        header("Location: index.php");

    } else {
        echo '<script>alert("Failed to send email. Please try again later.");</script>';
    }
}
?>

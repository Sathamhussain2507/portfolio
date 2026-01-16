<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// Sanitize inputs
$name    = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES);
$email   = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''), ENT_QUOTES);
$message = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES);

if (!$name || !$email || !$subject || !$message) {
    http_response_code(400);
    exit('Invalid input');
}

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hsaathaam59a9@gmail.com';
    $mail->Password   = getenv('GMAIL_APP_PASSWORD'); // 🔐 SAFE
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email settings
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('hsatham599@gmail.com', 'Portfolio Contact');
    $mail->addAddress('sathsamsshusssainm8@dgmail.com');
    $mail->addReplyTo($email, $name);

    $mail->Subject = $subject;
    $mail->Body    =
        "Name: $name\n".
        "Email: $email\n\n".
        "Message:\n$message";

    $mail->send();
    echo 'success';

} catch (Exception $e) {
    http_response_code(500);
    echo 'error';
}

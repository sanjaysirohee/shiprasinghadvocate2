<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Collect form data safely
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $subject = $_POST['subject'] ?? '';

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'mail.shiprasinghadvocate.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contact@shiprasinghadvocate.com'; // Lawyer's mail
    $mail->Password = 'india@P121';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sender (always the lawyer’s email)
   $mail->setFrom('contact@shiprasinghadvocate.com', 'Lawyer Website Contact Form');


    // Add Reply-To only if client email is valid
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail->addReplyTo($email, $name);
    }

    // Recipient
    $mail->addAddress('contact@shiprasinghadvocate.com', 'Lawyer');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "You got a message from <b>{$name}</b> ({$email}):<br><br>" . nl2br($message);

    $mail->send();
    echo "<script>alert('✅ Message has been sent successfully!'); window.location.href='enquiry';</script>";

} catch (Exception $e) {
    // Show error alert
    echo "<script>alert('❌ Message could not be sent. Error: {$mail->ErrorInfo}'); window.location.href='enquiry';</script>";
}

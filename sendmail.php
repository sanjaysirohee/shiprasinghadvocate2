<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

try {
    // Collect form data safely
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $subject = $_POST['subject'] ?? '';

    //Validate user's email
    $isValidEmail = !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);

    //Send to Lawyer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.shiprasinghadvocate.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contact@shiprasinghadvocate.com';
    $mail->Password = 'india@P121';
    $mail->SMTPSecure = 'tls'; // try 'ssl' if TLS doesn't work
    $mail->Port = 587; // or 465 if SSL

    $mail->setFrom('contact@shiprasinghadvocate.com', 'Lawyer Website Contact Form');
    if ($isValidEmail) $mail->addReplyTo($email, $name);
    $mail->addAddress('contact@shiprasinghadvocate.com', 'Lawyer');

    $mail->isHTML(true);
    $mail->Subject = "New Enquiry: " . htmlspecialchars($subject);
    $mail->Body = "
        <h3>New Message from Your Website</h3>
        <p><b>Name:</b> {$name}</p>
        <p><b>Email:</b> {$email}</p>
        <p><b>Message:</b><br>" . nl2br(htmlspecialchars($message)) . "</p>
    ";
    $mail->send();

    //sending message to user
    if ($isValidEmail) {
        $userMail = new PHPMailer(true);
        $userMail->isSMTP();
        $userMail->Host = 'mail.shiprasinghadvocate.com';
        $userMail->SMTPAuth = true;
        $userMail->Username = 'contact@shiprasinghadvocate.com';
        $userMail->Password = 'india@P121';
        $userMail->SMTPSecure = 'tls'; // or 'ssl'
        $userMail->Port = 587; // or 465

        $userMail->setFrom('contact@shiprasinghadvocate.com', 'Shipra Singh Advocate');
        $userMail->addAddress($email, $name);
        $userMail->isHTML(true);
        $userMail->Subject = "We have received your message!";
        $userMail->Body = "
            <p>Dear <b>{$name}</b>,</p>
            <p>Thank you for reaching out to <b>Shipra Singh Advocate</b>. We’ve received your message and will get back to you soon.</p>
            <p><b>Your Message:</b><br>" . nl2br(htmlspecialchars($message)) . "</p>
            <br><p>Best regards,<br><b>Shipra Singh Advocate Team</b></p>
        ";

        try {
            $userMail->send();
        } catch (Exception $userError) {
            error_log("User email failed: " . $userMail->ErrorInfo);
        }
    }

    echo "<script>alert('✔️Message has been sent successfully!'); window.location.href='enquiry';</script>";

} catch (Exception $e) {
    echo "<script>alert(' Message could not be sent. Error: {$mail->ErrorInfo}'); window.location.href='enquiry';</script>";
}
?>

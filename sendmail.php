<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_POST['vercode'])) {
  if ((empty($_SESSION["vercode"])) || ($_SESSION["vercode"] != $_POST['vercode'])) {
    die("<script>alert('Invalid Verification Code'); history.back();</script>");
  }
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require 'config.php';

try {
    // Collect form data safely
    $name = $_POST['name'] ?? '';
    $phoneno = $_POST['phoneno'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $subject = $_POST['subject'] ?? '';

    //Validate user's email
    $isValidEmail = !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);



    // Know query user location Code Start
    $ip_address=$_SERVER['REMOTE_ADDR'];
    /*Get user ip address details with geoplugin.net*/
    if ($ip_address != '127.0.0.1' && $ip_address != '::1') {

        $geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
         $addrDetailsArr = @unserialize(file_get_contents($geopluginURL));
        /*Get City name by return array*/
         $city = $addrDetailsArr['geoplugin_city'] ?? 'Not Defined';
        /*Get Country name by return array*/
        $country = $addrDetailsArr['geoplugin_countryName'] ?? 'Not Defined';
        /*Comment out these line to see all the posible details*/
        /*echo '<pre>';
        print_r($addrDetailsArr);
        die();*/

    }
    else {
    $city = 'Localhost';
    $country = 'Localhost';
    }
    if(!$city){
    $city='Not Define';
    }if(!$country){
    $country='Not Define';
    }
    $userLocation = $city .', '. $country;
    $userCountry = $country;
    // Know query user location Code End

    //to know the url of the  contacted  page
    $vpage_url = $_SERVER['HTTP_REFERER'] ?? 'Unknown';

    $stmt = $conn->prepare("INSERT INTO req_query_table (full_name, phone_number, email, message, subject,Location,vpage_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $phoneno, $email, $message, $subject, $userLocation,$vpage_url);

    if ($stmt->execute()) {
    // echo "Data savsed to database successfully<br>";
    } else {
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();


    
    
    

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
        <p><b>Phone Number:</b> {$phoneno}</p>
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
            <p>Thank you for reaching out to <b>Shipra Singh Advocate</b>. We have received your message and will get back to you soon.</p>
            <p><b>Your Message:</b><br>" . nl2br(htmlspecialchars($message)) . "</p>
            <br><p>Best regards,<br><b>Shipra Singh Advocate Team</b></p>
        ";

        try {
            $userMail->send();
        } catch (Exception $userError) {
            error_log("User email failed: " . $userMail->ErrorInfo);
        }
    }

    // Send message to Whatsapp Code Start
    $Message = "&type=text&message=Thanks+for+contacting+with+Shipra+Singh+Advocate.+We+have+received+your+message,+Please+write+your+concern+here+more+queries+here...";

  $url = 'https://chatbot.veloxn.com/api/send?number=91' . $phoneno . $Message . '&instance_id=68F267F3F0143&access_token=67b05e6bef4eb';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      echo 'Error: ' . curl_error($ch);
    }
    curl_close($ch);

    echo "<script>alert('✔️Message has been sent successfully!'); window.location.href='enquiry';</script>";

} catch (Exception $e) {
    echo "<script>alert(' Message could not be sent. Error: {$mail->ErrorInfo}'); window.location.href='enquiry';</script>";
}
?>

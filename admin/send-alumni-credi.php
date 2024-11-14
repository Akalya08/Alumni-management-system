<?php
session_start();
include  'include/config.php'; 
error_reporting(E_ALL);
ini_set('display_errors', '1');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
      
    $email=$_REQUEST['email'];
    $name=$_REQUEST['name']; 
 
    
    $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->AuthType = 'LOGIN';
            $mail->Username = 'alumnireply2024@gmail.com';
            $mail->Password = 'ytxt rfem oubw ysjh';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('alumnireply2024@gmail.com', 'Vivekanandha College Alumni Credentials');
            $mail->addAddress($email, $name);

            $randomNumber = rand(10000000, 99999999);
            $password = md5($randomNumber);
            $sql="update tblAdmin set password=:password where email=:email";

$query = $dbh -> prepare($sql);
$query->bindParam(':email',$email,PDO::PARAM_STR); 
$query->bindParam(':password',$password,PDO::PARAM_STR); 
$query -> execute();
            // Content
            $mail->isHTML(true); // Set to true if sending HTML content
            $mail->Subject = 'Alumni Credentials';
            $mail->Body = '<html><body><h1>hi '.$name.' </h1>, <br><p> Your Credentials followed by:</p> <br>
            <p>email :  '.$email.'</p>
            <p>password :  '.$randomNumber.'</p>
            <p>Thank you.</p>
            </body></html> ';

            // Send email
            $mail->send();
            echo 'Email sent successfully!';
            header('Location: alumni-details.php');
        } catch (Exception $e) {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }
     
  ?>
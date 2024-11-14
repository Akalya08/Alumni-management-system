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
            $mail->setFrom('alumnireply2024@gmail.com', 'Vivekanandha College Alumni ');
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true); // Set to true if sending HTML content
            $mail->Subject = 'Birthday Wishes';
            $mail->Body = '<html><body><h1>hi '.$name.' </h1>, <br><p>Happy birthday to our esteemed alumni! Your continued success reflects the excellence fostered at our institution, and we wish you a year filled with prosperity and joy! May you achieve great things both in your life and career.</p> <br> <img src="https://superbwishes.com/wp-content/uploads/2022/03/Happy-Birthday-Wishes-GIFs.gif" width="500px" height="500px">  </body></html> ';

            // Send email
            $mail->send();
            echo 'Email sent successfully!';
            header('Location: alumni-details.php');
        } catch (Exception $e) {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }
     
  ?>
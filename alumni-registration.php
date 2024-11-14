<?php
// error_reporting(0);
require_once('include/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$page = "reg";
$msg = $image_url = $error = $succmsg = ""; 
if(isset($_POST['submit']))
{ 
$name=$_POST['name'];
$mobile2=$_POST['mobile2'];
$mobile=$_POST['mobile'];
$email=$_POST['email'];
$department_name=$_POST['department_name'];
$batch=$_POST['batch'];
$dob=$_POST['dob']; 
$company_name=$_POST['company_name']; 
$role=$_POST['role']; 
$package=$_POST['package']; 
$company_location=$_POST['company_location']; 
$linkedin_id=$_POST['linkedin_id']; 
 $user_role = "ALUMNI";


 $targetDirectory = "uploads/";
$targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

 
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $msg="File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else { 
        $msg="File is not an image.";
        $uploadOk = 0;
    }
	
if (file_exists($targetFile)) {
	unlink($targetFile); 
    $msg="Sorry, file already exists.";
    // $uploadOk = 0;
}
 
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $msg="Sorry, your file is too large.";
    $uploadOk = 0;
}
 
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $msg="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}


if ($uploadOk == 0) {
    $msg= "Sorry, your file was not uploaded.";

} else {
	// var_dump($_FILES["fileToUpload"]);exit;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
		$image_url = basename($_FILES["fileToUpload"]["name"]);
		// var_dump($image_url);exit;
        $msg="The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        $msg="Sorry, there was an error uploading your file.";
    }
}
// exit;
$usrdbeml= $usrdbmble= "";
// Email id Already Exit

$usermatch=$dbh->prepare("SELECT mobile,email FROM tbladmin WHERE (email=:usreml || mobile=:mblenmbr)");
$usermatch->execute(array(':usreml'=>$email,':mblenmbr'=>$mobile)); 
while($row=$usermatch->fetch(PDO::FETCH_ASSOC))
{
$usrdbeml= $row['email'];
$usrdbmble=$row['mobile'];
}


if(empty($name))
{
  $nameerror="Please Enter Full Name";
}

 else if(empty($mobile))
 {
 $mobileerror="Please Enter Mobile No";
 }

 else if(empty($email))
 {
 $emailerror="Please Enter Email";
 }

else if($email==$usrdbeml || $mobile==$usrdbmble)
 {
  $error="Email Id or Mobile Number Already Exists!";
 }
 else if($uploadOk ==0){
	$error= $msg;
 }

 
else{
$sql="INSERT INTO tbladmin (name,email,mobile,mobile2,department_name,batch,dob,company_name,role,package,company_location,linkedin_id,user_role,image_url) Values(:name,:email,:mobile,:mobile2,:department_name,:batch,:dob,:company_name,:role,:package,:company_location,:linkedin_id,:user_role,:image_url)";

$query = $dbh -> prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':mobile2',$mobile2,PDO::PARAM_STR);
$query->bindParam(':department_name',$department_name,PDO::PARAM_STR);
$query->bindParam(':batch',$batch,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':company_name',$company_name,PDO::PARAM_STR);
$query->bindParam(':role',$role,PDO::PARAM_STR);
$query->bindParam(':package',$package,PDO::PARAM_STR);
$query->bindParam(':company_location',$company_location,PDO::PARAM_STR);
$query->bindParam(':linkedin_id',$linkedin_id,PDO::PARAM_STR);
$query->bindParam(':user_role',$user_role,PDO::PARAM_STR);
$query->bindParam(':image_url',$image_url,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId>0)
{

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
		$mail->addCC($email, $name);
		 

		// Content
		$mail->isHTML(true); // Set to true if sending HTML content
		$mail->Subject = 'Registration';
		$mail->Body = '<html><body><h1>Hi '.$name.' </h1>, <br><p>Phone : '.$mobile.'</p><p> Your have Successfully Register <br> Thank you ...</body></html> ';

		// Send email
		$mail->send();


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
		// $mail->addAddress($email, $name);
		$mail->addBCC('alumnireply2024@gmail.com',$name);

		// Content
		$mail->isHTML(true); // Set to true if sending HTML content
		$mail->Subject = 'Registration';
		$mail->Body = '<html><body><h1>Hi '.$name.' </h1>, <br><p>Phone : '.$mobile.'</p><p> New Alumni has Register our portal.please contact and verify the alumni. <br> Thank you ...</body></html> ';

		// Send email
		$mail->send();



		echo "<script>alert('Registration successfull. Please login');</script>";
echo "<script> window.location.href='admin/login.php?n=ALUMNI';</script>";
	} catch (Exception $e) {
		echo 'Error sending email: ' . $mail->ErrorInfo;
	}




}
else 
{
$error ="Registration Not successfully";
 }
}
 }
 
 ?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>ALUMNI Management System</title>
	<meta charset="UTF-8">
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/nice-select.css"/>
	<link rel="stylesheet" href="css/slicknav.min.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/style.css"/>

</head>
<body>
	<!-- Page Preloder -->
	

	<!-- Header Section -->
	<?php include 'include/header.php';?>
	<!-- Header Section end -->
	                                                                              
	<!-- Page top Section -->
	<section class="page-top-section set-bg" data-setbg="img/vcewnew-2023.jpg">
		<div class="container" style="    backdrop-filter: brightness(0.5);">
			<div class="row">
				<div class="col-lg-12 m-auto text-white">
					<h2>Registration</h2>
				</div>
			</div>
		</div>
	</section>
	<!-- Page top Section end -->

	<!-- Contact Section -->
	<section class="contact-page-section spad overflow-hidden">
		<div class="container">
			
			<div class="row">
				<div class="col-lg-2">
				</div>
				<div class="col-lg-8">
					<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($succmsg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($succmsg); ?> </div><?php }?><br><br>
					<form class="singup-form contact-form" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<input type="text" name="name" id="name" placeholder="Full Name" autocomplete="off"  required>
							</div>
							<div class="col-md-6">
								<input type="date" name="dob" id="dob" placeholder="Date of Birth" autocomplete="off" max="<?=date('Y-m-d')?>"  required>
							</div>
							<div class="col-md-6">
								<input type="text" name="email" id="email" placeholder="Your Email" autocomplete="off"  required>
							</div>
							<div class="col-md-6">
								<input type="text" name="mobile" id="mobile" maxlength="10" placeholder="Mobile Number" autocomplete="off"  required>
							</div>
							<div class="col-md-6">
								<input type="text" name="mobile2" id="mobile2" maxlength="10" placeholder="Alternative Mobile Number " autocomplete="off" >
							</div>
							<div class="col-md-6">
								
								<select name="department" id="department" required>
								<option value="">SELECT YOUR DEPARTMENT</option>
									<option value="IT">INFORMATION TECHNOLOGY</option>
									<option value="CST">COMPUTER SCIENCE AND TECHNOLOGY</option>
									<option value="CSE">COMPUTER SCIENCE AND ENGINEERING</option>
									<option value="EEE">ELECTRICAL AND ELECTRONICS ENGINEERING</option>
									<option value="ECE">ELECTRONICS AND COMMUNICATION ENGINEERING</option>
									<option value="BT">BIOTECHNOLOGY</option>
									<option value="BME">BIOMEDICAL ENGINEERING</option>

								</select>
							</div>
							<div class="col-md-6">
								<input type="text" name="batch" id="batch" placeholder="Your Batch Ex. 2011-2015" autocomplete="off"   required>
							</div>
							<div class="col-md-6">
							<input type="text" name="company_name" id="company_name" placeholder="Your Company name" autocomplete="off"  >
							</div>
							<div class="col-md-6">
	
								<select name="role" id="role" required>
								<option value="">SELECT YOUR ROLE</option>
									<option value="OWNER">OWNER</option>
									<option value="ENTREPRENEUR">ENTREPRENEUR</option>
									<option value="BUSINESS">BUSINESS</option>
									<option value="MANAGER">MANAGER</option>
									<option value="DEVELOPER">DEVELOPER</option>
									<option value="none">NONE OF ABOVE</option>

								</select>
							</div>

							<div class="col-md-6">
								<input type="text" name="package" id="package" placeholder="Your package details" autocomplete="off">
							</div>
							<div class="col-md-6">
								<input type="text" name="company_location" id="company_location" placeholder="Your company location" autocomplete="off">
							</div>
							<div class="col-md-6">
								<input type="text" name="linkedin_id" id="linkedin_id" placeholder="Your LinkedIn details" autocomplete="off">
							</div>
							<div class="col-md-6">
								<input type="file" name="fileToUpload" id="fileToUpload"  required>
							</div>
							<div class="col-md-6">
							 
							</div>
							<div class="col-md-4">
						<input type="submit" id="submit" name="submit" value="Register Now" class="site-btn sb-gradient">
								
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-2">
				</div>
			</div>
		</div>
	</section>
	<!-- Trainers Section end -->



	<!-- Footer Section -->
<?php include 'include/footer.php'; ?>
	<!-- Footer Section end -->
	
	<div class="back-to-top"><img src="img/icons/up-arrow.png" alt=""></div>

	<!--====== Javascripts & Jquery ======-->
	<script src="js/vendor/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/main.js"></script>

	</body>
</html>
 <style>
.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #dd3d36;
    color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #5cb85c;
    color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
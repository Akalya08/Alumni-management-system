<?php session_start();
error_reporting(0);
include  'include/config.php';
$page = "events"; 
$msg = $errormsg = "";
$image_url = "";
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
 
if(isset($_POST['Submit'])){
 
$event_name = $_POST['event_name'];$date_time = $_POST['date_time'];$place = $_POST['place'];$who = $_POST['who'];



$date_time = date('Y-m-d H:i:s',strtotime($date_time));

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



$sql="INSERT INTO tblevents (event_name,date_time,place,who,image_url) 
Values(:event_name,:date_time,:place,:who,:image_url)";
$query = $dbh -> prepare($sql);
$query->bindParam(':event_name',$event_name,PDO::PARAM_STR);
$query->bindParam(':date_time',$date_time,PDO::PARAM_STR);
$query->bindParam(':place',$place,PDO::PARAM_STR);
$query->bindParam(':who',$who,PDO::PARAM_STR); 
$query->bindParam(':image_url',$image_url,PDO::PARAM_STR); 
$query -> execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId>0)
{
echo "<script>alert('Events Added successfully.');</script>";
echo "<script> window.location.href='manage-events.php';</script>";
 }
else {

$errormsg= "Data not insert successfully";
 }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a">
   <title>Admin | Add Events</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
   <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>
    <main class="app-content">
      <h3> Add Events </h3>
      <hr/>
      <div class="row">
        
        <div class="col-md-12">
          <div class="tile">
             <!---Success Message--->  
          <?php if($msg){ ?>
          <div class="alert alert-success" role="alert">
          <strong>Well done!</strong> <?php echo htmlentities($msg);?>
          </div>
          <?php } ?>

          <!---Error Message--->
          <?php if($errormsg){ ?>
          <div class="alert alert-danger" role="alert">
          <strong>Oh snap!</strong> <?php echo htmlentities($errormsg);?></div>
          <?php } ?>
            <div class="tile-body">
              <form class="row" method="post" enctype="multipart/form-data">
                 

                <div class="form-group col-md-6">
                  <label class="control-label">Title Name</label>
                  <input class="form-control" name="event_name" id="event_name" type="text" placeholder="Enter your Title Name" required>
                </div>

               

                 <div class="form-group col-md-6">
                  <label class="control-label">Place</label>
                  <input class="form-control" type="text" name="place" name="place" placeholder="Enter Place" required>
                </div>

                 <div class="form-group col-md-6">
                  <label class="control-label">Chief Guest</label>
                  <input class="form-control" type="text" name="who" id="who" placeholder="Enter your Who Contect" required>
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Date Time</label>
                  <input type="datetime-local"  class="form-control" name="date_time" id="date_time" placeholder="Enter your Who Contect" required>
                </div>
                
                <div class="form-group col-md-6">
                  <label class="control-label">Event Image</label>
                  <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" placeholder="Enter your Who Contect" required>
                </div>
                 

                <div class="form-group col-md-4 align-self-end">
                  <input type="Submit" name="Submit" id="Submit" class="btn btn-primary" value="Submit">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/plugins/pace.min.js"></script>
  <script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      
  </body>
</html>

 
<?php } ?>
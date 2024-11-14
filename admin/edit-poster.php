<?php session_start();
error_reporting(0);
include  'include/config.php';
$page = "posters"; 
$msg = $errormsg = "";
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{

    $event_id = $_REQUEST['pid'];
 
if(isset($_POST['Submit'])){
 
    $poster_title = $_POST['poster_title'];$added_by = $_SESSION['adminid'];

$image_url = "";
 
$image_url="";
if(basename($_FILES["fileToUpload"]["name"])){
    $image_url = basename($_FILES["fileToUpload"]["name"]);
    $targetDirectory = "poster/";
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
     
    if ($_FILES["fileToUpload"]["size"] > 500000) {
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
     
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $msg="The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            $msg="Sorry, there was an error uploading your file.";
        }
    }
    
}else{
    $uploadOk =1 ;
}


if($uploadOk ==1){
    $qry = "";
    
    if($image_url){
        $qry = ",image_url=:image_url";
    }

    
        $sql="UPDATE tblposter set poster_title=:poster_title,added_by=:added_by
        ". $qry." 
        
         where id=:event_id";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':poster_title',$poster_title,PDO::PARAM_STR);
        $query->bindParam(':added_by',$added_by,PDO::PARAM_STR);
        $query->bindParam(':event_id',$event_id,PDO::PARAM_STR); 
        if($image_url){
            $query->bindParam(':image_url',$image_url,PDO::PARAM_STR);
        } 
       
        $query -> execute();
        // var_dump($query -> execute());exit;
        // $lastInsertId = $dbh->lastInsertId();
        
        echo "<script>alert('Poster updated successfully.');</script>";
        echo "<script> window.location.href='manage-poster.php';</script>";
     
       

}



}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a">
   <title>Admin | Edit Poster</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
 .image-input {
  text-aling: center;
}
.image-input input {
  display: none;
}
.image-input label {
  display: block;
  color: #FFF;
  background: #000;
  padding: 0.3rem 0.6rem;
  font-size: 115%;
  cursor: pointer;
}
.image-input label i {
  font-size: 125%;
  margin-right: 0.3rem;
}
.image-input label:hover i {
  animation: shake 0.35s;
}
.image-input img {
  max-width: 175px;
  /* display: none; */
}
.image-input span {
  display: none;
  text-align: center;
  cursor: pointer;
}

@keyframes shake {
  0% {
    transform: rotate(0deg);
  }
  25% {
    transform: rotate(10deg);
  }
  50% {
    transform: rotate(0deg);
  }
  75% {
    transform: rotate(-10deg);
  }
  100% {
    transform: rotate(0deg);
  }
} 

</style>


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
                 
              <?php 
              $adminid=$_SESSION['adminid'];
              $sql ="SELECT * from tblposter where id=:adminid ";
              $query= $dbh -> prepare($sql);
              $query->bindParam(':adminid',$event_id, PDO::PARAM_STR);
              $query-> execute();
              $results = $query -> fetchAll(PDO::FETCH_OBJ);
              $cnt=1;
              if($query->rowCount() > 0)
              {
              foreach($results as $result)
              { ?>


                <div class="form-group col-md-6">
                  <label class="control-label">Title Name</label>
                  <input class="form-control" name="poster_title" id="poster_title" type="text" placeholder="Enter your Title Name" value="<?=$result->poster_title?>" required>
                </div>

               
  
                
                <div class="form-group col-md-12">
                            <div class="image-input">
                                                        <input type="file" accept="image/*" id="imageInput" name="fileToUpload">
                                                        <label for="imageInput" class="image-button"><i
                                                                class="far fa-image"></i> Choose image</label>

                                                        <img src="<?="poster/".$result->image_url;?>" class="image-preview"> 

                                                        <span class="change-image">Choose different image</span>
                                                    </div>
                            </div>
                 

                <?php } }?>

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
      <script>
    $('#imageInput').on('change', function() {
	$input = $(this);
	if($input.val().length > 0) {
		fileReader = new FileReader();
		fileReader.onload = function (data) {
		$('.image-preview').attr('src', data.target.result);
		}
		fileReader.readAsDataURL($input.prop('files')[0]);
		$('.image-button').css('display', 'none');
		$('.image-preview').css('display', 'block');
		$('.change-image').css('display', 'block');
	}
});
						
$('.change-image').on('click', function() {
	$control = $(this);			
	$('#imageInput').val('');	
	$preview = $('.image-preview');
	$preview.attr('src', '');
	$preview.css('display', 'none');
	$control.css('display', 'none');
	$('.image-button').css('display', 'block');
});
</script>
  </body>
</html>
 
<?php } ?>
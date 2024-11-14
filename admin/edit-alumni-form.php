<?php
session_start();
error_reporting(0);
require_once('include/config.php');
if(strlen( $_SESSION["adminid"])==0)
    {   
header('location:login.php');
}
else{


if(isset($_POST['submit']))
{
$adminid=$_GET['alumniid'];
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
 $user_role = $_POST['user_role'];


 $image_url="";
if(basename($_FILES["fileToUpload"]["name"])){
    $image_url = basename($_FILES["fileToUpload"]["name"]);
    $targetDirectory = "../uploads/";
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

    
    $sql="update tbladmin set 
    name=:name,
    email=:email,
    mobile=:mobile,
    mobile2=:mobile2,
    department_name=:department_name,
    batch=:batch,
    dob=:dob,
    company_name=:company_name,
    role=:role,
    package=:package,
    company_location=:company_location,
    linkedin_id=:linkedin_id,
    user_role=:user_role 
    ". $qry." 
    
    where id=:adminid";
    $query = $dbh->prepare($sql);
    
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
    $query->bindParam(':adminid',$adminid,PDO::PARAM_STR);
    if($image_url){
        $query->bindParam(':image_url',$image_url,PDO::PARAM_STR);
    }
    
    $query -> execute();
    // $query->execute();
    //$msg="<script>toastr.success('Mobile info updated Successfully', {timeOut: 5000})</script>";
    echo "<script>alert('Profile has been updated.');</script>";
    echo "<script> window.location.href =profile.php;</script>";
}



}


 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Vali is a">
    <title>Admin Profile</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <div class="row">

            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Profile</h3>
                    <div class="tile-body">
                        <form class="row" method="post" enctype="multipart/form-data">
                            <?php 
              $adminid=$_GET['alumniid'];
              $sql ="SELECT * from tbladmin where id=:adminid ";
              $query= $dbh -> prepare($sql);
              $query->bindParam(':adminid',$adminid, PDO::PARAM_STR);
              $query-> execute();
              $results = $query -> fetchAll(PDO::FETCH_OBJ);
              $cnt=1;
              if($query->rowCount() > 0)
              {
              foreach($results as $result)
              { ?>

              <input type="hidden" name="user_role" value="<?=$result->user_role?>">
                            <div class="form-group col-md-12">
                                <label class="control-label">Full Name</label>
                                <input class="form-control" type="text" name="name" id="name"
                                    placeholder="Enter your name" value="<?php echo $result->name;?>" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Email</label>
                                <input class="form-control" type="text" name="email" id="email"
                                    placeholder="Enter your email" value="<?php echo $result->email;?>" readonly>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">DOB</label>
                                <input class="form-control" type="date" name="dob" id="dob" placeholder="Enter your "
                                    value="<?php echo $result->dob;?>" required>
                            </div>


                            <div class="form-group col-md-12">
                                <label class="control-label">Mobile No</label>
                                <input class="form-control" type="text" name="mobile" id="mobile"
                                    placeholder="Enter your Mobile" value="<?php echo $result->mobile;?>" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Mobile No</label>
                                <input class="form-control" type="text" name="mobile2" id="mobile2"
                                    placeholder="Enter your Mobile2" value="<?php echo $result->mobile2;?>" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Department Name</label>
                                <input class="form-control" type="text" name="department_name" id="department_name"
                                    placeholder="Enter your department_name"
                                    value="<?php echo $result->department_name;?>"  required>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Batch</label>
                                <input class="form-control" type="text" name="batch" id="batch"
                                    placeholder="Enter your batch" value="<?php echo $result->batch;?>"  required>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Company Name</label>
                                <input class="form-control" type="text" name="company_name" id="company_name"
                                    placeholder="Enter your company_name" value="<?php echo $result->company_name;?>" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">SELECT YOUR ROLE</option>
                                    <option value="OWNER" <?php if($result->role == "OWNER") { echo 'selected'; } ?>>OWNER</option>
                                    <option value="ENTREPRENEUR" <?php if($result->role == "ENTREPRENEUR") { echo 'selected'; } ?> >ENTREPRENEUR</option>
                                    <option value="BUSINESS" <?php if($result->role == "BUSINESS") { echo 'selected'; } ?> >BUSINESS</option>
                                    <option value="MANAGER" <?php if($result->role == "MANAGER") { echo 'selected'; } ?> >MANAGER</option>
                                    <option value="DEVELOPER" <?php if($result->role == "DEVELOPER") { echo 'selected'; } ?> >DEVELOPER</option>
                                    <option value="none" <?php if($result->role == "none") { echo 'selected'; } ?> >NONE OF ABOVE</option>

                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Package Details</label>
                                <input class="form-control" type="text" name="package" id="package"
                                    placeholder="Enter your package" value="<?php echo $result->package;?>" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Location</label>
                                <input class="form-control" type="text" name="company_location" id="company_location"
                                    placeholder="Enter your company_location"
                                    value="<?php echo $result->company_location;?>" required>
                            </div>


                            <div class="form-group col-md-12">
                                <label class="control-label">linkedin </label>
                                <input class="form-control" type="text" name="linkedin_id" id="linkedin_id"
                                    placeholder="Enter your linkedin_id" value="<?php echo $result->linkedin_id;?>" required>
                            </div>

                            <div class="form-group col-md-12">
                            <div class="image-input">
                                                        <input type="file" accept="image/*" id="imageInput" name="fileToUpload">
                                                        <label for="imageInput" class="image-button"><i
                                                                class="far fa-image"></i> Choose image</label>

                                                        <img src="<?="../uploads/".$result->image_url;?>" class="image-preview"> 

                                                        <span class="change-image">Choose different image</span>
                                                    </div>
                            </div>

                            <div class="form-group col-md-4 align-self-end">
                                <input type="submit" id="submit" name="submit" value="Update" class="btn btn-primary">

                            </div>
                            <?php }} ?>
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

</body>
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
</html>
<?php } ?>

<style>
.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #dd3d36;
    color: #fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
}

.succWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #5cb85c;
    color: #fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
}
</style>
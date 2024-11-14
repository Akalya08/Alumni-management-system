<?php session_start();
error_reporting(0);
$page= "alumni";
include  'include/config.php'; 
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
    $id = $_SESSION['adminid'] ;
    $name = $_SESSION['name'];
    $userRole = $_SESSION['user_role'];

    $dept = isset($_REQUEST['dept']) ? $_REQUEST['dept'] : null ;
    $batch = isset($_REQUEST['batch']) ? $_REQUEST['batch'] : null ;
    $company_name = isset($_REQUEST['company_name']) ? $_REQUEST['company_name'] : null ;

    $dptqry = "";
    if(!empty($dept)){
        $dptqry = " and department_name='".$dept."' ";
    }

    if(!empty($batch)){
        $dptqry.= " and batch='".$batch."' ";
    }

    if(!empty($company_name)){
        $dptqry.= " and company_name like '%".$company_name."%' ";
    }

    $isHideIcon = "";
    if($userRole == "STUDENT"){
        $isHideIcon = "display:none;";
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Vali is a responsive">

    <title><?=$userRole?> | Alumni Details </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
    .card-container {
        background-color: #231e39;
        border-radius: 5px;
        box-shadow: 0px 10px 20px -10px rgba(0, 0, 0, 0.75);
        color: #b3b8cd;
        padding-top: 30px;
        position: relative;
        width: 350px;
        max-width: 100%;
        text-align: center;
    }


    .card-container .round {
        border: 1px solid #03bfcb;
        border-radius: 50%;
        padding: 7px;
        width: 200px;
        height: 220px;

    }



    .skills {
        background-color: #1f1a36;
        text-align: center;
        padding: 5px;

    }

    .skills ul {

        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .skills ul li {
        border: 1px solid #2d2747;
        border-radius: 2px;
        display: inline-block;
        font-size: 12px;
        margin: 0 7px 7px 0;
        padding: 7px;
        cursor: pointer;
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

        <div class="app-title">
            <div>
                <h1><i class="fa fa-users"></i> Alumni Profiles</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Alumni Profiles</a></li>
            </ul>
        </div>

        <div class="">
            <form action="">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="form-group">Department</label>
                        <select name="dept" id="dept" class="form-control">
                            <option value="">select Department</option>
                            <?php   $sql="SELECT DISTINCT department_name from tblAdmin where user_role='ALUMNI'";
                  $query= $dbh->prepare($sql);
                  $query-> execute();
                  $fresults = $query -> fetchAll(PDO::FETCH_OBJ);
                  foreach($fresults as $fresult)
                  {
                   ?>
                            <option value="<?=$fresult->department_name?>" <?php if($fresult->department_name == $dept) { echo 'selected'; } ?>><?=$fresult->department_name?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3"><label for="form-group">Batch</label>
                        <select name="batch" id="batch" class="form-control">
                            <option value="">select Batch</option>
                            <?php   $bsql="SELECT DISTINCT batch from tblAdmin where user_role='ALUMNI'";
                  $bquery= $dbh->prepare($bsql);
                  $bquery-> execute();
                  $bfresults = $bquery -> fetchAll(PDO::FETCH_OBJ);
                  foreach($bfresults as $bfresult)
                  {
                   ?>




                            <option value="<?=$bfresult->batch?>" <?php if($bfresult->batch == $batch) { echo 'selected'; } ?>><?=$bfresult->batch?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3"><label for="form-group">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="<?=$company_name?>">
                    </div>
                    <div class="col-sm-3"><label for="form-group">Action</label><br>
                        <input type="submit" name="search" value="Search" class="btn btn-info btn-sm">
                    </div>
                </div>
            </form>
        </div>

<br>
        <div class="row">

            <?php   
            
             
            $sql="SELECT * from tblAdmin where user_role='ALUMNI'
                    ".$dptqry."
                     ORDER BY 
                    CASE 
                        WHEN name = '".$name."' THEN 1
                        WHEN role = 'ENTREPRENEUR' THEN 2
                        WHEN role = 'OWNER' THEN 3
                        ELSE 2
                    END";
                  $query= $dbh->prepare($sql);
                //   $query->bindParam(':user_role','ALUMNI', PDO::PARAM_STR);
                  $query-> execute();
                  $results = $query -> fetchAll(PDO::FETCH_OBJ);
                  foreach($results as $result)
                  {

                    if($userRole == "ALUMNI" && $result->id != $id){
                        $isHideIcon = "display:none";
                    }

                    $isHideFa = "";
                    if($userRole == "ALUMNI" && $result->id == $id){
                        $isHideFa = "display:none";
                    }
                   ?>


            <div class="col-sm-3">
                <div class="card-container">

                    <img class="round" src="<?='../uploads/'.$result->image_url?>" alt="user" />
                    <h3><?= $result->name;?></h3>
                    <h6>Works at <?= $result->company_name;?></h6>
                    <p>
                    <?php
                          if($userRole != "STUDENT"){
                            ?>
 <i class="fa fa-phone" aria-hidden="true"><?= $result->mobile;?></i>  <br />
                         <?php }
                        ?>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i> <?= $result->email;?> <br />
                        <i class="fa fa-diamond" aria-hidden="true"></i> <?= $result->role;?>
                    </p>

                    <div class="skills">
                        <ul>
                            <li title="send Alumni Birthday Wishes" style="<?=$isHideIcon.$isHideFa;?>"><a href="send-birthday.php?email=<?=$result->email;?>&name=<?= $result->name;?>"><i
                                        class="fa fa-birthday-cake primary" aria-hidden="true"></i></a></li>
                            <li title="send Message" style="<?=$isHideIcon;?>"><a href="send-message.php" ><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
                            <li title="Alumni linkedIn "><a href="<?=$result->linkedin_id?>" target="_blank"><i class="fa fa-linkedin-square"
                                        aria-hidden="true"></i></a></li>
                            <li title="Edit Alumni Details" style="<?=$isHideIcon;?>"><a href="edit-alumni-form.php?alumniid=<?=$result->id?>"><i class="fa fa-pencil-square-o"
                                        aria-hidden="true"></i></a></li>
                            <li title="View Alumni Details"><a href="view-alumni.php?alumniid=<?=$result->id?>"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                            <li title="send Alumni credentials" style="<?=$isHideIcon.$isHideFa;?>"><a  href="send-alumni-credi.php?email=<?=$result->email;?>&name=<?= $result->name;?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php } ?>

        </div>








    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
    $('#sampleTable').DataTable();
    </script>

</body>

</html>
<?php } ?>
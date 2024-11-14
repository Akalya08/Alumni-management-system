<?php session_start();
error_reporting(0);
$page= "posters";
include  'include/config.php'; 
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
    $id = $_SESSION['adminid'] ;
    $name = $_SESSION['name'];
    $userRole = $_SESSION['user_role'];
 

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
.slide-wrapper {
  display: inline-block;
  margin: 1em;
  width: 300px;
}

.slide-wrapper img {
  display: block;
  width: 300px;
  height: 400px;
}

.slide-wrapper .content {
  background: rgb(202,202,202);
  padding: 1rem;
  display: inline-block;
  min-width: 100%;
  width: 0;
}

* {
  box-sizing: border-box;
}

body {
   
  background: rgb(38,38,38);
  font-family: sans-serif;
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
                <h1><i class="fa fa-users"></i> Poster</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Poster</a></li>
            </ul>
        </div>



        <div class="row">
        <ol>
            <?php  
            $sql="SELECT tp.id,tp.poster_title, ta.name,tp.added_at,tp.image_url from tblposter tp inner join tbladmin ta on ta.id = tp.added_by";
                  $query= $dbh->prepare($sql);
                //   $query->bindParam(':user_role','ALUMNI', PDO::PARAM_STR);
                  $query-> execute();
                  $results = $query -> fetchAll(PDO::FETCH_OBJ);
                  foreach($results as $result)
                  {

                     
                   ?>


           
                <li class="slide-wrapper">
                    <img class="photo" src="<?='poster/'.$result->image_url?>" />
                    <div class="content">
                        <h2><?=$result->poster_title?></h2>

                        <p>Added By: <?=$result->name?></p>
                        
                    </div>

                </li>
           


            <?php } ?>
            </ol>
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
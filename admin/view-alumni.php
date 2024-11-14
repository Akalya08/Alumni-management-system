<?php session_start();
error_reporting(0);
include  'include/config.php'; 
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
$alumniid=$_GET['alumniid'];
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Vali is a">
    <title>Booking Details</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <div class="tile-body">
                        <a href="alumni-details.php" class="btn btn-success btn-sm" style="float:right">Back</a>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <?php
                                
                  $sql="SELECT * from tbladmin where id=:alumniid";
                  
                  $query= $dbh->prepare($sql);
                  
                  $query->bindParam(':alumniid',$alumniid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query -> fetchAll(PDO::FETCH_OBJ);
                  
                  foreach($results as $result)
                  {
                  ?>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $result->name; ?></td>
                                    <th>Email</th>
                                    <td><?php echo $result->email; ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile No 1</th>
                                    <td><?php echo $result->mobile; ?></td>
                                    <th>Mobile No 2</th>
                                    <td><?php echo $result->mobile2; ?></td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td><?php echo $result->department_name; ?></td>
                                    <th>Batch</th>
                                    <td><?php echo $result->batch; ?></td>
                                </tr>
                                <tr>
                                    <th>DOB</th>
                                    <td><?php echo $result->dob; ?></td>
                                    <th>Company Name</th>
                                    <td><?php echo $result->company_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?php echo $result->role; ?></td>
                                    <th>Package Details</th>
                                    <td><?php echo $result->package; ?></td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td><?php echo $result->company_location; ?></td>
                                    <th>LinkedIn</th>
                                    <td><?php echo $result->linkedin_id; ?></td>
                                     
                                </tr> 
                                <tr>
                                    <th>Profile Image</th>
                                    <td colspan="3"><img src="<?='../uploads/'.$result->image_url?>" alt="" width="100px" height="100px"></td>

                                </tr>
                                <?php    } ?>
                            </thead>
                        </table>


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
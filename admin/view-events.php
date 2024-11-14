<?php session_start();
error_reporting(0);
$page= "events";
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
    :root {
        --blue: #4e73bc;
        --white: #fff;
        --dark: #313b40;
        --light: #eaedef;
        --blue-grey: #545b6d;
    }

    /* -- Event Card Layout --*/
    .event {
        display: grid;
        grid-template-columns: repeat(2, auto);
        grid-template-rows: auto;
        grid-gap: 0;
    }

    .image-wrapper {
        grid-column: span 2;
        grid-row: 1;
        position: relative;
    }

    .event-date {
        grid-column: span 1;
        grid-row: 2;
    }

    .event-time {
        grid-column: span 1;
        grid-row: 2;
    }

    .event-title {
        grid-column: span 2;
        grid-row: 3;
        background-color: var(--light);
        padding: 1.5em 1.2em 2.5em;
        margin-top: -0.2em;
    }

    .event-details {
        grid-column: span 1;
        grid-row: 4;
    }

    .event-tickets {
        grid-column: span 1;
        grid-row: 4;
    }

    .card {
        width: 23em;
        margin: 1em;
        font: 1em "Roboto", sans-serif;
    }

    .image-wrapper:after {
        content: "";
        position: absolute;
        display: block;
        margin: auto;
        top: 0;
        left: 0;
        width: 100%;
        height: 99%;
        background-image: linear-gradient(to top, rgba(64, 101, 173, 0.7) 0%, rgba(0, 0, 0, 0) 100%)
    }

    .featured-image {
        width: 100%;
        border-radius: 0.45em 0.45em 0 0;
        object-fit: cover;
        max-height: 16em;
    }

    .title {
        font-size: 1.25em;
        font-weight: 900;
        color: var(--dark);
    }

    .link {
        text-decoration: none;
        transition: color 200ms ease-in 0s;
        color: var(--dark);
    }

    .link:hover {
        color: var(--blue);
    }

    .address {
        font-style: normal;
    }

    .venue {
        font-weight: 900;
    }

    .venue,
    .streetAddress,
    .locality {
        margin: 0.3em 0;
        color: var(--dark);
        opacity: 0.85;
    }

    .event-details {
        background-color: var(--blue-grey);
        padding: 1em;
        text-align: center;
        border-radius: 0 0 0 0.45em;
        transition: background-color 200ms ease-in 0s;
        cursor: pointer;
    }

    .event-details:hover {
        background-color: #3b404c;
    }

    .event-tickets {
        background-image: linear-gradient(to right, #618ee6 0%, #3a5fb3 75%);
        padding: 1em;
        text-align: center;
        border-radius: 0 0 0.45em 0;
        transition: background 200ms ease-in 0s;
        cursor: pointer;
    }

    .event-tickets:hover {
        background-image: linear-gradient(to right, #618ee6 20%, #3a5fb3 100%);
    }

    .event-details .link,
    .event-tickets .link {
        color: var(--white);
        letter-spacing: 0.1em;
    }

    .date,
    .time {
        z-index: 2000;
        background-color: var(--white);
        color: var(--dark);
        font-weight: 900;
        text-align: center;
        /* padding: 0.8em 0.5em 0.3em; */
        margin: -1.5em 0 -1.5em;
        max-height: 1.5em;
    }

    .date time,
    .time time {
        opacity: 0.85;
    }

    .date {
        margin-left: 1em;
        border-radius: 0.3em 0 0 0.3em;
        border-right: 2px solid var(--dark);
    }

    .time {
        /* max-width: 5em; */
        border-radius: 0 0.3em 0.3em 0;
    }

    @media screen and (max-width: 400px) {
        .card {
            width: 100%;
        }

        .date,
        .time {
            text-align: center;
        }

        .time {
            max-width: 60%;
        }
    }

    @media screen and (max-width: 300px) {

        .date,
        .time {
            font-size: 0.8em;
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

        <div class="app-title">
            <div>
                <h1><i class="fa fa-users"></i> Events</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Events</a></li>
            </ul>
        </div>


        <!-- <div class="row"> -->

            <div class="row">
            <?php   
            
             
            $sql="SELECT * from tblevents";
                  $query= $dbh->prepare($sql);
                //   $query->bindParam(':user_role','ALUMNI', PDO::PARAM_STR);
                  $query-> execute();
                  $results = $query -> fetchAll(PDO::FETCH_OBJ);
                  foreach($results as $result)
                  {

                     
                   ?>



            <!-- most important info goes first, then use styling to arrange items -->
            <section class="event card">
                <!-- chose an h2 since this will be part of a page someday & that page will need an h1 i.e. <h1>Events</h1> -->
                <div class="event-title title-block">
                    <h2 class="title">
                       <?=$result->event_name?>
                    </h2>
                    <p class="venue">
                        <a class="link" href="#" target="_blank" aria-label="Visit venue website">
                        Cheif Guest : <?=$result->who?>
                        </a>
                    </p>
                    <!--itemscope is more for SEO-->
                    <address class="address">
                        <!--look into micro formats for the address elements-->
                        <p class="streetAddress">  Place : <?=$result->place?></p>
                        <!--use abbreviation tag for CA-->
                        <!-- <span class="locality">San Francisco, CA 94107</span> -->
                    </address>
                </div>
                <div class="image-wrapper">
                    <img class="featured-image" src="<?='uploads/'.$result->image_url?>"
                        alt="The Paper Kites Band standing in a hallway" />
                    <div class="overlay"></div>
                </div>
                <!-- address, date, then time - from general to specific -->
                <div class="event-date date">
                    <time datetime="2018-10-16"><?=date('d-M-Y',strtotime($result->date_time))?></time>
                </div>
                <div class="event-time time">
                    <time datetime="19:00"><?=date('h:i A',strtotime($result->date_time))?></time>
                </div>
                 
            </section>

                    <?php } ?>
                    </div>
        <!-- </div> -->








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
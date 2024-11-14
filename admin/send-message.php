<?php session_start();
error_reporting(0);
$page = "msg";
include  'include/config.php'; 
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
$adminid= $_SESSION['adminid'];

$receiver_id = isset($_REQUEST['receiver_id']) ? $_REQUEST['receiver_id'] : null;

if(isset($_REQUEST['send']) && isset($_REQUEST['text'])){

    $receiver_id = $_REQUEST['receiver_id'];
    $text = $_REQUEST['text'];
    
    $sql="INSERT INTO tblmessage (sender_id,receiver_id,text) 
    Values(:sender_id,:receiver_id,:text)";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':sender_id',$adminid,PDO::PARAM_STR);
    $query->bindParam(':receiver_id',$receiver_id,PDO::PARAM_STR);
    $query->bindParam(':text',$text,PDO::PARAM_STR); 
    $query -> execute();
    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId>0)
    {
    echo "<script>alert('Message Send successfully.');</script>";
    echo "<script> window.location.href='send-message.php?receiver_id=".$receiver_id."&text=';</script>";
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
    <title>Send Message</title>
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
        --body-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --msger-bg: #fff;
        --border: 2px solid #ddd;
        --left-msg-bg: #ececec;
        --right-msg-bg: #579ffb;
    }

    html {
        box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
        margin: 0;
        padding: 0;
        box-sizing: inherit;
    }


    .msger {
        display: flex;
        flex-flow: column wrap;
        justify-content: space-between;
        width: 100%;
        height: 500px !important;
        max-width: 867px;
        margin: 25px 10px;
        height: calc(100% - 50px);
        border: var(--border);
        border-radius: 5px;
        background: var(--msger-bg);
        box-shadow: 0 15px 15px -5px rgba(0, 0, 0, 0.2);
    }

    .msger-header {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border-bottom: var(--border);
        background: #eee;
        color: #666;
    }

    .msger-chat {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
    }

    .msger-chat::-webkit-scrollbar {
        width: 6px;
    }

    .msger-chat::-webkit-scrollbar-track {
        background: #ddd;
    }

    .msger-chat::-webkit-scrollbar-thumb {
        background: #bdbdbd;
    }

    .msg {
        display: flex;
        align-items: flex-end;
        margin-bottom: 10px;
    }

    .msg:last-of-type {
        margin: 0;
    }

    .msg-img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        background: #ddd;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        border-radius: 50%;
    }

    .msg-bubble {
        max-width: 450px;
        padding: 15px;
        border-radius: 15px;
        background: var(--left-msg-bg);
    }

    .msg-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .msg-info-name {
        margin-right: 10px;
        font-weight: bold;
    }

    .msg-info-time {
        font-size: 0.85em;
    }

    .left-msg .msg-bubble {
        border-bottom-left-radius: 0;
    }

    .right-msg {
        flex-direction: row-reverse;
    }

    .right-msg .msg-bubble {
        background: var(--right-msg-bg);
        color: #fff;
        border-bottom-right-radius: 0;
    }

    .right-msg .msg-img {
        margin: 0 0 0 10px;
    }

    .msger-inputarea {
        display: flex;
        padding: 10px;
        border-top: var(--border);
        background: #eee;
    }

    .msger-inputarea * {
        padding: 10px;
        border: none;
        border-radius: 3px;
        font-size: 1em;
    }

    .msger-input {
        flex: 1;
        background: #ddd;
    }

    .msger-send-btn {
        margin-left: 10px;
        background: rgb(0, 196, 65);
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.23s;
    }

    .msger-send-btn:hover {
        background: rgb(0, 180, 50);
    }

    .msger-chat {
        background-color: #fcfcfe;

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
            <div class="col-sm-12">
                <section class="msger">
                    <header class="msger-header">
                        <div class="msger-header-title">
                            <i class="fa fa-comment-alt"></i> CHATBOX
                        </div>
                        <div class="msger-header-options">
                            <span><i class="fa fa-cog"></i></span>
                        </div>
                    </header>



                    <main class="msger-chat">

                        <?php
                                        $sql="SELECT tm.sender_id,ta.name as sender_name,ta.image_url as sender_image, tm.receiver_id,ta1.name as receiver_name,ta1.image_url as receiver_image, tm.text,tm.added_at from tblmessage tm INNER JOIN tbladmin ta ON ta.id = tm.sender_id
                                        INNER JOIN tbladmin ta1 ON ta1.id = tm.receiver_id where (sender_id=:sender_id and receiver_id=:receiver_id) or (sender_id=:receiver_id and receiver_id=:sender_id) order by tm.id";
                                        $query= $dbh->prepare($sql);
                                        $query->bindParam(':receiver_id',$receiver_id, PDO::PARAM_STR);
                                        $query->bindParam(':sender_id',$adminid, PDO::PARAM_STR);
                                        $query-> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                    
                                        if($query -> rowCount() > 0)
                                        {
                                        foreach($results as $result)
                                        {
 
                                                $fileUrl='../uploads/';
                                            
                                        
                                            if($result->sender_id != $adminid) { 
                                               
                                        ?>

                        <div class="msg left-msg">
                            <div class="msg-img"
                                style="background-image: url('<?=$fileUrl.$result->sender_image?>')">
                            </div>

                            <div class="msg-bubble">
                                <div class="msg-info">
                                    <div class="msg-info-name"><?=$result->sender_name?></div>
                                    <div class="msg-info-time"><?=$result->added_at?></div>
                                </div>

                                <div class="msg-text">
                                    <?=$result->text?>
                                </div>
                            </div>
                        </div>
                        <?php }
                        
                                if($result->sender_id  == (int)$adminid) { 
                                    
                                ?>
                        <div class="msg right-msg">
                            <div class="msg-img"
                                style="background-image: url('<?=$fileUrl.$result->sender_image?>')">
                            </div>

                            <div class="msg-bubble">
                                <div class="msg-info">
                                    <div class="msg-info-name"><?=$name ?></div>
                                    <div class="msg-info-time"><?=$result->added_at?></div>
                                </div>

                                <div class="msg-text">
                                    <?=$result->text?>
                                </div>
                            </div>
                        </div>

                        <?php } } } ?>

                    </main>
 

                    <form class="msger-inputarea" action="" method="get">
                        <select name="receiver_id" id="receiver_id" required>
                            <option value="">select person</option>
                            <?php   $sql="SELECT id,name,user_role from tbladmin where id<>:sender_id";
                             
                  $query= $dbh->prepare($sql);
                  $query->bindParam(':sender_id',$adminid, PDO::PARAM_STR);
                  $query-> execute();
                  $fresults = $query -> fetchAll(PDO::FETCH_OBJ);
                  foreach($fresults as $fresult)
                  {

                    $sql1 = "SELECT * FROM `tblmessage` WHERE sender_id =:sender_id"; 
                    $result1 = $dbh->prepare($sql1); 
                    $result1->bindParam(':sender_id',$fresult->id, PDO::PARAM_STR);
                    $result1-> execute();
                    $fresults1 = $result1 -> fetchAll(PDO::FETCH_OBJ);
                    $number_of_rows = count($fresults1);

                   ?>
                            <option value="<?=$fresult->id?>" <?php if($fresult->id == $receiver_id) { echo 'selected'; } ?>>
                                <?=$fresult->name." - ".$fresult->user_role?> - <span><?=$number_of_rows?></span></option>
                            <?php } ?>
                        </select>
                        <input type="text" class="msger-input" name="text" placeholder="Enter your message..." required>
                        <input type="submit" class="msger-send-btn" name="send" value="Send">
                    </form>
                </section>
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

    $("#receiver_id").change(function(){
            $(".msger-inputarea").submit();
    });
    </script>

</body>



</html>

<?php } ?>
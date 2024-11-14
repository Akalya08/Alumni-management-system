<?php

session_start();
$user_role = $_SESSION['user_role'];

$eventPage = "";
$posterPage = "";
if($user_role == "ADMIN"){
    $eventPage = "manage-events.php";
    $posterPage = "manage-poster.php";
}else if($user_role == "ALUMNI") {
    $posterPage = "manage-poster.php";
    $eventPage = "view-events.php";
}else{
    $eventPage = "view-events.php";
    $posterPage = "view-poster.php";
}
?>

<aside class="app-sidebar">

    <ul class="app-menu">
        <li><a class="app-menu__item <?= $page == "dashoard" ? 'active' : '' ;?>" href="index.php"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        <li><a class="app-menu__item  <?= $page == "alumni" ? 'active' : '' ;?>" href="alumni-details.php"><i
                    class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Alumni Profiles</span></a></li>

        <li><a class="app-menu__item  <?= $page == "events" ? 'active' : '' ;?>" href="<?=$eventPage?>"><i
                    class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Events</span></a></li>

        <li><a class="app-menu__item  <?= $page == "posters" ? 'active' : '' ;?>" href="<?=$posterPage?>"><i
                    class="app-menu__icon fa fa-id-card"></i><span class="app-menu__label">Poster</span></a></li>

        <li><a class="app-menu__item   <?= $page == "msg" ? 'active' : '' ;?>" href="send-message.php"><i
                    class="app-menu__icon fa fa-comments"></i><span class="app-menu__label">Send Message</span></a></li>


    </ul>
    </li>
    </ul>
</aside>
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/header/headHtml.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/topNav/topNav.php";
// info to build top nav
$dir = $_SERVER['PHP_SELF'];
$url = explode('/', $dir);
$active = strtolower($url[1]);

echo "<ul class='nav nav-tabs'>";
// get navs from db and parse
$topNav = new topNav();
foreach ($topNav->getTopNav() as $nav) {
    if ($_SESSION['user']['permission'] >= $nav['permission']) {
        echo "<li";
        // apply active class to appropriate nav
        if (strtolower($nav['href']) == $active || (strtolower($_SERVER['PHP_SELF']) == "/".$active && $nav['href'] == "")) {
            echo " class='active'";                 // ^^ for index.php (dashboard)
        }
        echo "><a href='/".$nav['href']."'>".$nav['display']."</a></li>";
    }

}

echo "</ul>";

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/user/user.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/dbo/connection.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/task/task.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/login/login.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/attributes/priority.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/attributes/status.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/attributes/frequency.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/attributes/permission.php";
session_start();
$page = strtolower($_SERVER['PHP_SELF']);
$loginPage = "/login/index.php";

if ($page !== $loginPage) {
    if (!isset($_SESSION['login'])) {
        header("Location: /login");
    }
}
echo "<html>
        <head>";
        // float header right if not login page
        if ($page !== $loginPage) {
            echo " <style>
                #header{
                    float: right;
                }
                </style>";
        }
echo "  <title>TMS</title>
        <link href=\"/css/bootstrap.css\" rel=\"stylesheet\" type=\"text/css\">
        <link rel=\"stylesheet\" href=\"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css\" />
        <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\"></script>
        <script src=\"http://code.jquery.com/ui/1.10.3/jquery-ui.js\"></script>
        <script src='/js/bootstrap.js'></script>
        <script src=\"/js/ajax.js\" ></script>
        </head><body><div class='pageWrap'>";
        if ($page !== $loginPage) {
            echo "<a style='position:absolute; right:0px; top:-15px' href='/logout'>Log Out</a>";
        }
       
        if (isset($_SESSION['login'])) {
            echo "<div style='position:absolute; left:0px; top:-15px'>Hi ".$_SESSION['user']['username']."</div>";
        }
        
        echo "<div class='page-header'>";
        //echo "<span class='glyphicon glyphicon-copyright-mark' style='float:right'></span>";
        echo "<h2 id='header' align='center'>TMS <small>Task Management System<span class='glyphicon glyphicon-registration-mark' style=''></span></small></h2>";
        echo "</div>";
        
 
/*
 * the following is included in the footer
 * </div> <- pageWrap
 * </body>
 * </html>
 */
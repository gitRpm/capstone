
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
echo "<script src='/js/Chart.js-master/Chart.js'></script>";
echo "<script src='Dashboard/dashboardJs.js'></script>";
echo "<div class='mainContent' style='height:500px'>";
echo "<canvas id='barChart' width='600' height='400'></canvas>";
echo "</div>";
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";
?>


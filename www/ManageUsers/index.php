
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
include "/userEditDialog.php";
include "/userViewDialog.php";
echo "<div class='mainContent' >";
echo "<br />";
echo "<h3 style='margin:auto; padding:15px 0 15px; width:95%'>Users</h3>";
echo "<div class='tableWrap'>";
echo "<table class='table table-hover table-striped table-bordered' style='width:95%; margin:auto' >";
echo "<thead>";
echo "<th id='user_id'><span class='sortableUser'>ID</span></th>";
echo "<th id='permission_id'><span class='sortableUser'>Permission</span></th>";
echo "<th id='first_name'><span class='sortableUser'>First Name</span></th>";
echo "<th id='last_name'><span class='sortableUser'>Last Name</span></th>";
echo "<th id='username'><span class='sortableUser'>Username</span></th>";
echo "<th id='view'>View</th>";
echo "<th id='edit'>Edit</th>";
echo "</thead>";
echo "<tbody>";
$users = new user();
foreach($users->getUsers() as $user) {
    $users->displayInnerTable($user);
}
echo "</tbody>";
echo "</table>";
echo "</div>";


?>

    
        

</div>
<?php
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";
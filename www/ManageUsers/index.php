
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
include "/userEditDialog.php";
include "/userViewDialog.php";
echo "<div class='mainContent' >";
echo "<br />";
echo "<h3 style='margin:0; padding:5'>Users</h3>";
echo "<div class='tableWrap'>";
echo "<table class='table table-hover table-striped table-bordered' >";
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




<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
echo "<div class='mainContent'>";
/**/
echo "<br />";
echo "<div class='formWrap'>";
if (isset($_POST['submit'])) {
    $user = new user;
    if($user->checkIfUserExists($_POST['formUsername'])){
        if($user->insertUser($_POST)) {
            $message = "User " . $_POST['formUsername'] . " successfully created.";
        } else {
            $message = "There was an error creating the user.";
        }
    } else {
        $message = "User already exists.";
    }
    echo "<br /><div class='alert alert-success' style='margin-left:100px'>" . $message . "</div>";
}
include $_SERVER['DOCUMENT_ROOT']."/../util/user/userForm.php";
echo "</div>";
echo "</div>";
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";
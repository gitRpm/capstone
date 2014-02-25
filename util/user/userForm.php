<?php
$page = strtolower($_SERVER['PHP_SELF']);
$addUser = "/adduser/index.php";
if ($page == $addUser) {
    echo "<form id='createUser' class='form-horizontal' role='form' method='POST' action=''>";
    echo "<h2 style='margin-left:26%'>Add User</h2>";
} else {
    echo "<form id='dialogFormEditUser' class='form-horizontal' role='form' method='POST' action=''>";
}
if ($page != $addUser) {
    echo "<div class='form-group'>";
    echo "<label class='col-sm-3 control-label'>User ID</label>";
    echo "<div class='col-sm-9'>";
    echo "<input type='hidden' name='formUserId' value='' />";
    echo "<p class='lead' id='formUserId'></p>";
    echo "</div>";
    echo "</div>";
}
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Permission</label>";
echo "<div class='col-sm-9'>";
echo "<select class='form-control' name='formPermissions'>";
$permission = new permission();
foreach ($permission->getPermissions() as $id => $per) {
    echo "<option value='".$id."'>".$per."</option>";
}
echo "</select>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>First Name</label>";
echo "<div class='col-sm-9'>";
echo "<input class='form-control' rows='9' name='formFirstName'/>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Last Name</label>";
echo "<div class='col-sm-9'>";
echo "<input class='form-control' rows='9' name='formLastName'/>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Username</label>";
echo "<div class='col-sm-9'>";
echo "<input class='form-control' rows='9' name='formUsername'/>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Password</label>";
echo "<div class='col-sm-9'>";
echo "<input class='form-control' type='password' rows='9' name='formPassword'/>";
echo "</div>";
echo "</div>";


if ($page != $addUser) {
    echo "<div class='col-sm-offset-3 col-sm-1'>";
    echo "<button type='submit' class='btn btn-default' name='cancel'>Cancel</button>";
    echo "</div>";
}
if ($page == $addUser) {
echo "<div class='col-sm-offset-10 col-sm-1'>";
    echo "<button type='submit' class='btn btn-primary' name='submit'>";
    echo "Add User";
    echo "</button>";
    echo "</div>";
} else {
    echo "<div class='col-sm-offset-1 col-sm-1'>";
    echo "<button type='submit' class='btn btn-primary' name='submit'>";
    echo "Update";
    echo "</button>";
    echo "</div>";
}
echo "</form>";
if ($page != $addUser) {
    echo "<div class='col-sm-offset-1 col-sm-1'>";
    echo "<button type='submit' class='btn btn-danger' name='user-delete'>";
    echo "Delete";
    echo "</button>";
    echo "</div>";
}
<?php
$page = strtolower($_SERVER['PHP_SELF']);
$addTask = "/addtask/index.php";
if ($page == $addTask) {
    echo "<form id='createTask' class='form-horizontal' role='form' method='POST' action=''>";
    echo "<h2 style='margin-left:26%'>Add Task</h2>";
} else {
    echo "<form id='dialogFormEdit' class='form-horizontal' role='form' method='POST' action=''>";
}
if ($page != $addTask) {
    echo "<div class='form-group'>";
    echo "<label class='col-sm-3 control-label'>Task ID</label>";
    echo "<div class='col-sm-9'>";
    echo "<input type='hidden' name='formTaskId' value='' />";
    echo "<p class='lead' id='formTaskId'></p>";
    echo "</div>";
    echo "</div>";
}
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Priority</label>";
echo "<div class='col-sm-9'>";
echo "<select class='form-control' name='formPriorities'>";
$priority = new priority();
foreach ($priority->getPriorities() as $id => $pri) {
    echo "<option value='".$id."'>".$pri."</option>";
}
echo "</select>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Description</label>";
echo "<div class='col-sm-9'>";
echo "<textarea class='form-control' rows='9' name='formDescription'></textarea>";
echo "</div>";
echo "</div>";
if ($page != $addTask) {
    echo "<div class='form-group'>";
    echo "<label class='col-sm-3 control-label'>Status</label>";
    echo "<div class='col-sm-9'>";
    echo "<select class='form-control' name='formStatus'>";
    $status = new status();
    foreach ($status->getStatuses() as $id => $stat) {
        echo "<option value='".$id."'>".$stat."</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<input type='hidden' name='formStatus' value='1'>";
}
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Frequency</label>";
echo "<div class='col-sm-9'>";
echo "<select class='form-control' name='formFrequency'>";
$frequency = new frequency();
foreach ($frequency->getFrequencies() as $id => $freq) {
    echo "<option value='".$id."'>".$freq."</option>";
}
echo "</select>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Assigned To</label>"; 
echo "<div class='col-sm-9'>";
echo "<select class='form-control' name='formAssigned'>";
$users = new user();
foreach ($users->getUsers() as $id => $user) {
    echo "<option value='".$id."'>".$user['username']."</option>";
}
echo "</select>";
echo "</div>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label class='col-sm-3 control-label'>Due Date</label>"; 
echo "<div class='col-sm-9'>";    
echo "<input class='datepicker' data-date-format='mm/dd/yyyy' name='formDateDue' value=''>";
echo "</div>";
echo "</div>";
if ($page != $addTask) {
    echo "<div class='form-group'>";
    echo "<label class='col-sm-3 control-label'>Date Created</label>"; 
    echo "<div class='col-sm-9'>";
    echo "<input class='datepicker' data-date-format='mm/dd/yyyy' name='formDateCreated' disabled>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label class='col-sm-3 control-label'>Date Completed</label>"; 
    echo "<div class='col-sm-9'>";
    echo "<input class='datepicker' data-date-format='mm/dd/yyyy' name='formDateCompleted' disabled>";
    echo "</div>";
    echo "</div>";
    echo "<div class='col-sm-offset-3 col-sm-1'>";
    echo "<button type='submit' class='btn btn-default' name='cancel'>Cancel</button>";
    echo "</div>";
}
if ($page == $addTask) {
echo "<div class='col-sm-offset-10 col-sm-1'>";
    echo "<button type='submit' class='btn btn-primary' name='submit'>";
    echo "Add Task";
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
if ($page != $addTask) {
    echo "<div class='col-sm-offset-1 col-sm-1'>";
    echo "<button type='submit' class='btn btn-danger' name='delete'>";
    echo "Delete";
    echo "</button>";
    echo "</div>";
}
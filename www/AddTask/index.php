
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
echo "<div class='mainContent'>";
/**/
echo "<br />";
echo "<div class='formWrap'>";
if (isset($_POST['submit'])) {
    $task = new task;
    if($task->insertTask($_POST)) {
        $message = "Task " . $task->insertTask($_POST) . " successfully created.";
        echo "<br /><div class='alert alert-success' style='margin-left:100px'>" . $message . "</div>";
    }
}
include $_SERVER['DOCUMENT_ROOT']."/../util/task/taskForm.php";
echo "</div>";
echo "</div>";
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";
?>
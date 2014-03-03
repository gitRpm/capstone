
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
echo "<div class='mainContent'>";
/**/
echo "<br />";
echo "<div class='formWrap'>";
if (isset($_POST['submit'])) {
    $task = new task;
    $taskId = $task->insertTask($_POST);
    if($taskId) {
        $message = "Task " . $taskId . " successfully created.";
        $class = 'success';
    } else {
        $message = "Could not create task.";
        $class = 'danger';
    }
    echo "<br /><div class='alert alert-".$class."' style='margin-left:100px'>" . $message . "</div>";
}
include $_SERVER['DOCUMENT_ROOT']."/../util/task/taskForm.php";
echo "</div>";
echo "</div>";
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";
?>

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/../util/topNav/topNavBuild.php";
if ($_SESSION['user']['permission'] > 1) {
    include "/taskEditDialog.php";
}
include "/taskViewDialog.php";
echo "<style>
    th#task_description {
    width:250px;
}

th#task_id {
    width:40px;
}

th#priority_id {
    width:50px;
}

th#status_id {
    width:100px;
}

th#markComplete {
    width:55px;
}

th#markComplete {
    width:95px;
}

th#username {
    width:175px;
}

th#due_date, #date_completed, #date_created {
    width:115px;
}

.tableWrap {
    border-bottom: 1px solid #dddddd;
    display: block;
    max-height: 300px;
    overflow-y: scroll;
}
    </style>";
$tasks = new task();
echo "<div class='mainContent' >";
echo "<br />";
foreach($tasks->getFreq() as $key => $freq) {
    echo "<h3 style='margin:0; padding:5'>". $freq ."</h3>";
    echo "<div class='tableWrap'>";
    echo "<table id='".$key."' class='table table-hover table-striped table-bordered' >";
    echo "<thead>";
    echo "<th id='task_id'><span class='sortable'>ID</span></th>";
    echo "<th id='priority_id'><span class='sortable'>Priority</span></th>";
    echo "<th id='task_description'><span class='sortable'>Description</span></th>";
    echo "<th id='status_id'><span class='sortable'>Status</span></th>";
    echo "<th id='markComplete'>Complete</th><th id='username'><span class='sortable'>Assigned</span></th>";
    echo "<th id='due_date'><span class='sortable'>Due</span></th>";
    echo "<th id='date_created'><span class='sortable'>Created</span></th>";
    echo "<th id='date_completed'><span class='sortable'>Completed</span></th>";
    echo "<th id='view'>View</th>";
    if ($_SESSION['user']['permission'] > 1) {
        echo "<th id='edit'>Edit</th>";
    }
    echo "</thead>";
    echo "<tbody>";
    foreach($tasks->getAll() as $task) {
        if ($key == $task['freqId']) {
            $tasks->displayInnerTable($task);
        }
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

?>

    
        

</div>
<?php
include $_SERVER['DOCUMENT_ROOT']."/../util/footer/footer.php";
?>


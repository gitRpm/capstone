<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/task/task.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/dbo/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/user/user.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['purpose'] == 'markComplete') {
        $taskId = $_GET['taskId'];
        $statusId = $_GET['statusId'];
        if ($statusId == 2) {
            $statusId = 1;
        } else {
            $statusId = 2;
        }
        $task = new task();
        $task->updateTaskStatus($taskId, $statusId);
        /*$array = $task->getOne($taskId);
        $ajaxResponse = array('statusId'=>$array['statusId'],
                'status'=>$array['status']
            );
        if (isset($array['className'])) {
            $ajaxResponse['className'] = $array['className'];
        }
        echo json_encode($ajaxResponse);
        exit();*/
        echo json_encode($task->getOne($taskId));
    }

    if ($_GET['purpose'] == 'sort') {
        $column = $_GET['column'];
        $order = $_GET['order'];
        $frequency = $_GET['frequency'];
        $tasks = new task();
        foreach ($tasks->getSorted($column, $order, $frequency) as $task) {
            $tasks->displayInnerTable($task);
        }
    }

    if ($_GET['purpose'] == 'view' || $_GET['purpose'] == 'edit') {
        $task = new task();
        echo json_encode($task->getOne($_GET['taskId']));
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($_POST['purpose'] == 'update') {
        $data = array();
        parse_str($_POST['data'], $data);
        $taskDescription = $data['formDescription'];
        $priorityId = $data['formPriorities'];
        $statusId = $data['formStatus'];
        $dueDate = $data['formDateDue'];
        $frequencyId = $data['formFrequency'];
        $assignedTo = $data['formAssigned'];
        $taskId = $data['formTaskId'];
        $task = new task();
        $task->updateTask($taskDescription, $priorityId, $statusId, $dueDate, $frequencyId, $assignedTo, $taskId);
    }
    
    if ($_POST['purpose'] == 'delete') {
        $task = new task();
        $task->deleteTask($_POST['taskId']);
    }
}
<?php
class task {
    
    function getAll() {
        $con = new connection();
         // get the tasks
        $this->stmt = $con->con->prepare("SELECT t.task_id, t.frequency_id, p.priority_display, t.task_description, s.status_display, t.status_id, t.due_date, t.date_created, t.date_completed, u.username FROM tasks t INNER JOIN frequency_type f ON f.frequency_type_id = t.frequency_id INNER JOIN priority p ON p.priority_id = t.priority_id INNER JOIN status s ON s.status_id = t.status_id INNER JOIN users u ON u.user_id = t.assigned_to ORDER BY t.due_date");
        $this->stmt->execute();
        $this->stmt->bind_result($taskId, $freqId, $priority, $taskDesc, $status, $statusId, $dueDate, $dateCreated, $dateCompleted, $assignedTo);

        while ($this->stmt->fetch()) {
            $tasks[$taskId] = array('taskId'=>$taskId, 'freqId'=>$freqId, 'priority'=>$priority, 'taskDesc'=>$taskDesc, 'status'=>$status, 'statusId'=>$statusId, 'dueDate'=>$this->formatDate($dueDate), 'dateCreated'=>$this->formatDate($dateCreated), 'dateCompleted'=>$this->formatDate($dateCompleted), 'assignedTo'=>$assignedTo);
            if ($tasks[$taskId]['statusId'] == 2) {
                $tasks[$taskId]['className']='success';
            } else if ($tasks[$taskId]['statusId'] == 3) {
                $tasks[$taskId]['className']='danger';
            }
        }
        
        $this->stmt->close();
        return $tasks;
    }
    
    function getSorted($column, $order, $frequency) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/user/user.php";
        $con = new connection();
         // get the tasks
        $this->stmt = $con->con->prepare("SELECT t.task_id, t.frequency_id, t.priority_id, p.priority_display, t.task_description, s.status_display, t.status_id, t.due_date, t.date_created, t.date_completed, u.username FROM tasks t INNER JOIN frequency_type f ON f.frequency_type_id = t.frequency_id INNER JOIN priority p ON p.priority_id = t.priority_id INNER JOIN status s ON s.status_id = t.status_id INNER JOIN users u ON u.user_id = t.assigned_to WHERE t.frequency_id = ? ORDER BY $column $order ");
        $this->stmt->bind_param('i', $fre);
        $fre = (int)$frequency;
        $this->stmt->execute();
        
        $this->stmt->bind_result($taskId, $freqId, $priorityId, $priority, $taskDesc, $status, $statusId, $dueDate, $dateCreated, $dateCompleted, $assignedTo);
        while ($this->stmt->fetch()) {
            $tasks[$taskId] = array('taskId'=>$taskId, 'freqId'=>$freqId, 'priorityId'=>$priorityId, 'priority'=>$priority, 'taskDesc'=>$taskDesc, 'status'=>$status, 'statusId'=>$statusId, 'dueDate'=>$this->formatDate($dueDate), 'dateCreated'=>$this->formatDate($dateCreated), 'dateCompleted'=>$this->formatDate($dateCompleted), 'assignedTo'=>$assignedTo);
            if ($tasks[$taskId]['statusId'] == 2) {
                $tasks[$taskId]['className']='success';
            } else if ($tasks[$taskId]['statusId'] == 3) {
                $tasks[$taskId]['className']='danger';
            }
        }
        $this->stmt->close();
        return $tasks;
    }
    function getOne($id) {
        $con = new connection();
         // get the tasks
        $this->stmt = $con->con->prepare("SELECT t.task_id, t.frequency_id, f.frequency_type_display, p.priority_display, p.priority_id, t.task_description, s.status_display, t.status_id, t.due_date, t.date_created, t.date_completed, u.username, t.assigned_to FROM tasks t INNER JOIN frequency_type f ON f.frequency_type_id = t.frequency_id INNER JOIN priority p ON p.priority_id = t.priority_id INNER JOIN status s ON s.status_id = t.status_id INNER JOIN users u ON u.user_id = t.assigned_to WHERE task_id = ?");
        $this->stmt->bind_param('i', $id);
        $this->stmt->execute();
        $this->stmt->bind_result($taskId, $freqId, $freqDisplay, $priority, $priorityId, $taskDesc, $status, $statusId, $dueDate, $dateCreated, $dateCompleted, $assignedTo, $assignedToId);
        while ($this->stmt->fetch()) {
            $task = array('taskId'=>$taskId, 'freqId'=>$freqId, 'freqDisplay'=>$freqDisplay, 'priority'=>$priority, 'priorityId'=>$priorityId, 'taskDesc'=>$taskDesc, 'status'=>$status, 'statusId'=>$statusId, 'dueDate'=>$this->formatDate($dueDate), 'dateCreated'=>$this->formatDate($dateCreated), 'dateCompleted'=>$this->formatDate($dateCompleted), 'assignedTo'=>$assignedTo, 'assignedToId'=>$assignedToId);
            if ($task['statusId'] == 2) {
                $task['className']='success';
            } else if ($task['statusId'] == 3) {
                $task['className']='danger';
            }
        }
        $this->stmt->close();
        return $task;
    }
    function updateTask($taskDescription, $priorId, $statId, $dDate, $freqId, $assTo, $tId) {
        $oldStatus = $this->checkStatus($tId);
        $con = new connection();
        $priorityId = (int)$priorId;
        $statusId = (int)$statId;
        $dueDate = $this->formatDateForEntry($dDate);
        $frequencyId = (int)$freqId;
        $assignedTo = (int)$assTo;
        $taskId = (int)$tId;
        if ($oldStatus !== $statusId) {
           if ($statusId == 2) {
               $dateCompleted = $this->formatDateForEntry(date("Y-m-d H:i:s"));
           } else {
               $dateCompleted = NULL;
           }
           $this->stmt = $con->con->prepare("UPDATE task_management.tasks SET task_description=?, priority_id=?, status_id=?, due_date=?, date_completed=?, frequency_id=?, assigned_to=? WHERE task_id=?");
           $this->stmt->bind_param('siissiii', $taskDescription, $priorityId, $statusId, $dueDate, $dateCompleted, $frequencyId, $assignedTo, $taskId);
       } else {
           $this->stmt = $con->con->prepare("UPDATE task_management.tasks SET task_description=?, priority_id=?, status_id=?, due_date=?, frequency_id=?, assigned_to=? WHERE task_id=?");
           $this->stmt->bind_param('siisiii', $taskDescription, $priorityId, $statusId, $dueDate, $frequencyId, $assignedTo, $taskId);
       }
        
        $this->stmt->execute();
        if(!$this->stmt->execute()) {
           printf("error message: \n", $this->stmt->error);
        }
        $this->stmt->close();
    }
    
    function insertTask($param) {
        
        $param['formPriorities'] = (int)$param['formPriorities'];
        $param['formStatus'] = (int)$param['formStatus'];
        $param['formFrequency'] = (int)$param['formFrequency'];
        $param['formAssigned'] = (int)$param['formAssigned'];
        $param['formDateDue'] = $this->formatDateForEntry($param['formDateDue']);
        
        $dateCreated = $this->formatDateForEntry(date("Y-m-d H:i:s"));
        $con = new connection();
        $this->stmt = $con->con->prepare("INSERT INTO tasks (task_description, priority_id, status_id, frequency_id, assigned_to, due_date, date_created) VALUES (?,?,?,?,?,?,?)");
        $this->stmt->bind_param('siiiiss', $param['formDescription'], $param['formPriorities'], $param['formStatus'], $param['formFrequency'], $param['formAssigned'], $param['formDateDue'], $dateCreated);
        if(!$this->stmt->execute()) {
           return false;
        } else {
            return $this->stmt->insert_id;
        }
        $this->stmt->close();
    }
    
    function deleteTask($taskId) {
        
        $taskId = (int)$taskId;
        $con = new connection();
        $this->stmt = $con->con->prepare("DELETE FROM tasks WHERE task_id = ?");
        $this->stmt->bind_param('i', $taskId);
        if(!$this->stmt->execute()) {
           return false;
        } else {
            return true;
        }
        $this->stmt->close();
    }
    
    function getFreq() {
        $con = new connection();
        // get daily, weekly, monthly
        $this->stmt = $con->con->prepare("SELECT * FROM frequency_type ORDER BY frequency_type_id");
        $this->stmt->execute();
        $this->stmt->bind_result($frId, $freq);
        while($this->stmt->fetch()) {
            $freqArray[$frId] = $freq;
        }
        $this->stmt->close();
        return $freqArray;
    }
    function updateTaskStatus($taskId, $statusId) {
       $oldStatus = $this->checkStatus($taskId);
       $con = new connection();
       if ($oldStatus !== $statusId) {
           if ($statusId == 2) {
               $dateCompleted = $this->formatDateForEntry(date("Y-m-d H:i:s"));
               
           } else {
               $dateCompleted = NULL;
           }
           $this->stmt = $con->con->prepare("UPDATE tasks SET status_id = ?, date_completed = ? WHERE task_id = ?");
           $this->stmt->bind_param('isi', $statusId, $dateCompleted, $taskId);
       } else {
           $this->stmt = $con->con->prepare("UPDATE tasks SET status_id = ? WHERE task_id = ?");
           $this->stmt->bind_param('ii', $statusId, $taskId);
       }
       if(!$this->stmt->execute()) {
           printf("error message: \n", $this->stmt->error);
       }
       $this->stmt->close();
   }
   function displayInnerTable($task) {
        
        echo "<tr id='".$task['taskId']."'>";
        echo "<td>".$task['taskId']."</td>";
        echo "<td class='priority'><span class='glyphicon glyphicon-exclamation-sign ".$task['priority']."'></span></td>";
        echo "<td class='description'>".$task['taskDesc']."</td>";
        echo "<td name='status' id='".$task['statusId']."' ";
            if (isset($task['className'])){
                echo "class = '".$task['className']."' ";
            }
        echo ">".$task['status']."</td>";
        //echo "<td><input class='markComplete' id='".$task['taskId']."' name='".$task['statusId']."' type='checkbox' /></td>";
        echo "<td><input class='markComplete' type='checkbox'";
            if ($task['statusId'] == 2) {
                echo " checked";
            }
            if (!$_SESSION['user']['permission'] >1) {
                if ($_SESSION['user']['username'] == $task['username']) {
                    echo " readonly";
                }
            }
        echo " /></td>";
        echo "<td class='assignedTo'>".$task['assignedTo']."</td>";
        echo "<td class='dueDate'>".$task['dueDate']."</td>";
        echo "<td class='dateCreated'>".$task['dateCreated']."</td>";
        echo "<td class='dateCompleted'>".$task['dateCompleted']."</td>";
        echo "<td class='viewTask' id='".$task['taskId']."'><span class='glyphicon glyphicon-eye-open'></span></td>";
        if ($_SESSION['user']['permission'] >1) {
            echo "<td class='editTask' id='".$task['taskId']."'><span class='glyphicon glyphicon-pencil'></span></td>";
        }
        echo "</tr>";
    }
    
    function formatDate($date) {
        if ($date == null) {
            $formatedDate = '';
        } else {
            $Date = new DateTime($date);
            $formatedDate = $Date->format('m/d/Y');
        }
        return $formatedDate;
    }
    
    function formatDateForEntry($date) {
        if ($date == null) {
            $formatedDate = null;
        } else {
            $formatedDate = date('Y/m/d H:i:s', strtotime($date));
        }
        return $formatedDate;
    }
    
    function checkStatus($taskId) {
        $con = new connection();
         // get the tasks
        $this->stmt = $con->con->prepare("SELECT t.status_id FROM tasks t WHERE t.task_id = ?");
        $this->stmt->bind_param('i', $taskId);
        $this->stmt->execute();
        $this->stmt->bind_result($stat);
        while ($this->stmt->fetch()) {
            $statusId = $stat;
        }
        $this->stmt->close();
        return $statusId;
    }
}

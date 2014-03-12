<?php
//include_once '/db_connect.php';
class chart {
    
    function getBarChart() {
        $con = new connection();
        $this->stmt = $con->con->prepare("SELECT u.username,
            sum(case when status_id = 1 then 1 else 0 end) numberIncomplete, 
            sum(case when status_id = 2 then 1 else 0 end) numberCompleted,
            sum(case when status_id = 3 then 1 else 0 end) numberPastDue
            FROM tasks t
            INNER JOIN users u
            ON u.user_id = t.assigned_to
            WHERE date_created BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            GROUP BY t.assigned_to");
        $this->stmt->execute();
        $this->stmt->bind_result($username, $incomplete, $completed, $pastDue);
        $i = 0;
        while ($this->stmt->fetch()) {
            
            $chartData[$i] = array('user' => $username, 'incomplete' => $incomplete, 'completed' => $completed, 'pastDue' => $pastDue);
            $i++;
        }
        $this->stmt->close();
        return $chartData;
    }
    
    function getPieChart() {
        $con = new connection();
        $this->stmt = $con->con->prepare("SELECT sum(case when status_id = 1 then 1 else 0 end) numberIncomplete,
            sum(case when status_id = 2 then 1 else 0 end) numberCompleted,
            sum(case when status_id = 3 then 1 else 0 end) numberPastDue,
            sum(case when status_id = 1 || status_id = 2 || status_id = 3 then 1 else 0 end) totalNumber
            FROM tasks t WHERE date_created BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
        $this->stmt->execute();
        $this->stmt->bind_result($incomplete, $complete, $pastDue, $total);
        while ($this->stmt->fetch()) {
            $chartData['incomplete'] = $incomplete;
            $chartData['complete'] = $complete;
            $chartData['pastDue'] = $pastDue;
            $chartData['total'] = $total;
        }
        $this->stmt->close();
        return $chartData;
    }
    
}

<?php
class priority {
    
    public function getPriorities() {
        $con = new connection();
         // get the priorities
        $this->stmt = $con->con->prepare("SELECT priority_id, priority_display FROM priority ORDER BY priority_id DESC;");
        $this->stmt->execute();
        $this->stmt->bind_result($priorityId, $priorityDisplay);

        while ($this->stmt->fetch()) {
            $priority[$priorityId] = $priorityDisplay;
        }
        $this->stmt->close();
        return $priority;
    }
}

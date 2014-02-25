<?php
class status {
    
    public function getStatuses() {
        $con = new connection();
         // get the statuses
        $this->stmt = $con->con->prepare("SELECT status_id, status_display FROM status ORDER BY status_id ASC;");
        $this->stmt->execute();
        $this->stmt->bind_result($statusId, $statusDisplay);

        while ($this->stmt->fetch()) {
            $status[$statusId] = $statusDisplay;
        }
        $this->stmt->close();
        return $status;
    }
}

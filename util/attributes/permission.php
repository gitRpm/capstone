<?php
class permission {
    
    public function getPermissions() {
        $con = new connection();
         // get the permissions
        $this->stmt = $con->con->prepare("SELECT permission_id, permission_display FROM permissions ORDER BY permission_id ASC;");
        $this->stmt->execute();
        $this->stmt->bind_result($permissionId, $permissionDisplay);

        while ($this->stmt->fetch()) {
            $permission[$permissionId] = $permissionDisplay;
        }
        $this->stmt->close();
        return $permission;
    }
}

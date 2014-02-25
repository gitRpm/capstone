<?php
class topNav {
    function getTopNav() {
        
        // create connection
        $con = new connection();
        // prepared statement
        $this->stmt = $con->con->prepare("SELECT display_name, href, permission_id FROM top_nav ORDER BY top_nav.order ASC");
        $this->stmt->execute();
        $this->stmt->bind_result($display_name, $href, $permission);
        $i = 0;
        while ($this->stmt->fetch()) {
            $nav[$i] = array('display'=>$display_name, 'href'=>$href, 'permission'=>$permission);
            $i++;
        }

        $this->stmt->close();
        return $nav;
        
    }
    
}

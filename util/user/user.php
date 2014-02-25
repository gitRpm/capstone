<?php
//include_once '/db_connect.php';
class user {
    
    function getUserInfo($u) {
        $con = new connection();
        $this->stmt = $con->con->prepare("SELECT user_id, first_name, last_name, username, password, permission_id FROM users WHERE username = ?");
        $this->stmt->bind_param('s', $u);
        $this->stmt->execute();
        $this->stmt->bind_result($userId, $firstName, $lastName, $user, $pass, $permissionId);
        
        while ($this->stmt->fetch()) {
            $user = array('userId' => $userId, 'username' => $user, 'firstName' => $firstName, 'lastName' => $lastName, 'permission' => $permissionId);
        }
        $this->stmt->close();
        return $user;
    }
    
    function getUserInfoById($id) {
        $con = new connection();
        $id = (int)$id;
        $this->stmt = $con->con->prepare("SELECT user_id, first_name, last_name, username, password, permission_id FROM users WHERE user_id = ?");
        $this->stmt->bind_param('i', $id);
        $this->stmt->execute();
        $this->stmt->bind_result($userId, $firstName, $lastName, $user, $pass, $permissionId);
        
        while ($this->stmt->fetch()) {
            $user = array('userId' => $userId, 'username' => $user, 'password' => $pass, 'firstName' => $firstName, 'lastName' => $lastName, 'permission' => $permissionId);
        }
        $this->stmt->close();
        return $user;
    }
    
    function getUsers() {
        $con = new connection();
        $this->stmt = $con->con->prepare("SELECT u.user_id, u.username, u.first_name, u.last_name, p.permission_display FROM users u INNER JOIN permissions p ON u.permission_id = p.permission_id ORDER BY username ASC");
        $this->stmt->execute();
        $this->stmt->bind_result($userId, $username, $firstName, $lastName, $permission);
        
        while ($this->stmt->fetch()) {
            $users[$userId] = array('userId' => $userId, 'username' => $username, 'firstName' => $firstName, 'lastName' => $lastName, 'permission' => $permission);
        }
        $this->stmt->close();
        return $users;
    }
    
    function checkIfUserExists($username) {
        
        $con = new connection();
        var_dump($username);
        $this->stmt = $con->con->prepare("SELECT user_id FROM users WHERE username = ?");
        $this->stmt->bind_param('s', $username);
        $this->stmt->execute();
        $this->stmt->bind_result($userId);
        $this->stmt->store_result();
        return ($this->stmt->num_rows < 1 );
        $this->stmt->close();
    }
    
    function insertUser($param) {
        
        $param['formPermissions'] = (int)$param['formPermissions'];
        $con = new connection();
        $this->stmt = $con->con->prepare("INSERT INTO users (first_name, last_name, username, password, permission_id) VALUES (?,?,?,?,?)");
        $this->stmt->bind_param('ssssi', $param['formFirstName'], $param['formLastName'], $param['formUsername'], $param['formPassword'], $param['formPermissions']);
        return $this->stmt->execute();
        $this->stmt->close();
        
    }
    
    function displayInnerTable($user) {
        echo "<tr id='".$user['userId']."'>";
        echo "<td>".$user['userId']."</td>";
        echo "<td class='permission' >".$user['permission']."</td>";
        echo "<td class='firstName'>".$user['firstName']."</td>";
        echo "<td class='lastName'>".$user['lastName']."</td>";
        echo "<td class='username'>".$user['username']."</td>";
        echo "<td class='viewUser' id='".$user['userId']."'><span class='glyphicon glyphicon-eye-open'></span></td>";
        echo "<td class='editUser' id='".$user['userId']."'><span class='glyphicon glyphicon-pencil'></span></td>";
        echo "</tr>";
    }
   
}

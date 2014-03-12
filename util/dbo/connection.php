<?php
class connection {
    
    function __construct() {
        date_default_timezone_set(timezone_name_from_abbr("CST"));
        // create connection when object is created
        $this->con = new mysqli('localhost','taskManager','5vDxeAKndP7nQYvV','task_management');
        // throw error if connection fails
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
        if (mysqli_connect_errno()) {
            echo "Conection Failed: " . mysqli_connect_errno();
            exit();
        }
    }
}

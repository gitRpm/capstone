<?php
class login {
    
    public $message;
    
    function checkCredentials($userInput) {
        //if form was submitted
        if (isset($userInput['post'])) {
        
            $userPost = $userInput['username'];
            $passPost = $userInput['password'];
            //if username is empty
            if ($userPost == "") {
                $this->message = "Username cannot be empty.";
            }
            //if password is empty
            if ($passPost == "") {
                if (isset($this->message)) {
                    $this->message = $this->message . "<br>Password cannot be empty.";
                } else {
                    $this->message = "Password cannot be empty.";
                }
            }

            if (!isset($this->message)) {
                // create connection
                $con = new connection();
                // prepared statement
                $this->stmt = $con->con->prepare("SELECT * FROM users WHERE users.username = ?");
                $this->stmt->bind_param('s', $userPost);
                $this->stmt->execute();
                $this->stmt->store_result();
                $this->stmt->bind_result($user_id, $first_name, $last_name, $username, $password, $permission_id);
                $match = true;

                // if nothing was returned or if password does not match
                if ($this->stmt->num_rows < 1) {
                   $match = false;
                } else {
                    while ($this->stmt->fetch()) {
                        //validate username and password in database
                        if ($password !== $passPost) {
                            $match = false;
                        }
                    }
                }
                $this->stmt->close();
                if (!$match) {
                    $this->message = "Invalid Username or Password.";
                } else {
                    $_SESSION['login'] = true;
                    // create the user
                    $user = new user();
                    $_SESSION['user'] = $user->getUserInfo($username);
                    header("Location: /");
                }
            }
        }
    }
}
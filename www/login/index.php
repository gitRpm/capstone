<?php
include $_SERVER['DOCUMENT_ROOT'] . "/../util/header/headHtml.php";
$login = new login();
$login->checkCredentials($_POST);
if (isset($login->message)) {
    echo "<div class='alert alert-danger'>" . $login->message . "</div>";
}

?>
<div class='jumbotron'>
    <div class='form-container'>
        <form role='form' action='' method='POST'>
            <div class='form-group'>
                <label for='sername'>Username</label>
                <input type='username' class='form-control' name='username' placeholder='Enter Username'>
            </div>
            <div class='form-group'>
                <label for='password'>Password</label>
                <input type='password' class='form-control' name='password' placeholder='Password'>
            </div>
            <button type='submit' name='post' class='btn btn-default'>Login</button>
        </form>
    </div>
</div>
</div> 
    </body>

</html>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/task/task.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/user/user.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/dbo/connection.php";
if ($_REQUEST['data'] === 'users') {
    $users = new user();
    $userInfo = array();
    foreach ($users->getUsers() as $key => $val) {
        $userInfo[$key]['username'] = $val['username'];
        $userInfo[$key]['complete'] = 30;
        $userInfo[$key]['incomplete'] = 20;
        $userInfo[$key]['pastDue'] = 10;
    }
    echo json_encode($userInfo);
}
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/task/task.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/dbo/db_connect.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/user/user.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['purpose'] == 'edit') {
        $user = new user();
        $user->getUserInfoById($_GET['userId']);
        echo json_encode($user->getUserInfoById($_GET['userId']));
    }
}
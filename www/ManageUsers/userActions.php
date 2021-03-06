<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/task/task.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/dbo/connection.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/user/user.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['purpose'] == 'edit' || $_GET['purpose'] == 'view') {
        $user = new user();
        $user->getUserInfoById($_GET['userId']);
        echo json_encode($user->getUserInfoById($_GET['userId']));
    }
    
    if ($_GET['purpose'] == 'sort') {
        $user = new user();
        $array = $user->getSortedUsers($_GET['sortBy'], $_GET['order']);
        foreach ($array as $value) {
            echo $user->displayInnerTable($value);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['purpose'] == 'update') {
        $data = array();
        parse_str($_POST['data'], $data);
        $permission = $data['formPermissions'];
        $firstName = $data['formFirstName'];
        $lastName = $data['formLastName'];
        $username = $data['formUsername'];
        $userId = $data['formUserId'];
        $user = new user();
        $user->updateUser($permission, $firstName, $lastName, $username, $userId);
    }
    
    if ($_POST['purpose'] == 'delete') {
        $user = new user();
        $user->deleteUser($_POST['userId']);
    }
}
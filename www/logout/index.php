<?php
include $_SERVER['DOCUMENT_ROOT'] . "/../util/header/headHtml.php";
session_destroy();
header("Location: /");
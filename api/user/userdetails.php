<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once "../../models/auth.php";
include_once "../../config/config.php";

$auth = new Auth();

if(!empty($_POST['hash']) && !empty($_POST['userid'])){
    echo $auth::userdetails($_POST['hash'],$_POST['userid']);
}
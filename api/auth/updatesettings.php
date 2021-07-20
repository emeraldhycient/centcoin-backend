<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once "../../models/auth.php";

$auth = new Auth();

if( !empty($_POST["userid"])){
    echo $auth::updatesettings($_POST["userid"],$_POST["username"],$_POST["email"],$_POST["password"]);
}
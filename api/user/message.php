<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/user.php";

$user = new users();

if(!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["message"])){
    echo $user::message($_POST["email"],$_POST["name"],$_POST["message"]);
}
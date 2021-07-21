<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/user.php";

$user = new users();

if(!empty($_POST["fullname"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) &&
!empty($_POST["accountbalance"]) && !empty($_POST["plan"]) && !empty($_POST["currency"])
){
    echo $user::updateuser($_POST["userid"],$_POST["fullname"],$_POST["username"],$_POST["password"],$_POST["email"],$_POST["accountbalance"],
    $_POST["plan"],$_POST["currency"],$_POST["isadmin"],$_POST["status"]);
}
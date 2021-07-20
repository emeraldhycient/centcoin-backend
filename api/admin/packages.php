<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/admin.php";

$admin = new admin();

if(isset($_GET["all"])){
     echo $admin::packages();
}

if(isset($_POST["update"])){
    if(!empty($_POST["id"]) && !empty($_POST["plan"]) && !empty($_POST["duration"]) && !empty($_POST["percentage"]) && !empty($_POST["mindep"]) && !empty($_POST["maxdep"]) ){
        echo $admin::updatePackage($_POST["id"],$_POST["plan"],$_POST["duration"],$_POST["percentage"],$_POST["mindep"],$_POST["maxdep"]);
    }
}
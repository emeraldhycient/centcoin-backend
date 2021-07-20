<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/admin.php";

$admin = new admin();


if(isset($_GET["unprocessed"])){
    echo $admin::unprocessedwithdrawals();
}

if(isset($_GET["all"])){
    echo $admin::withdrawals();
}

if(isset($_POST["update"])){
    if(!empty($_POST["status"]) && !empty($_POST["userid"])){
        echo $admin::processwithdrawal($_POST["status"],$_POST["userid"],$_POST["amount"]);
    }
}
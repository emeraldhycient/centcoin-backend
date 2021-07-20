<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/user.php";

$user = new users();
if(isset($_GET["userid"])){
    echo $user::allTransactions($_GET["userid"]);
}
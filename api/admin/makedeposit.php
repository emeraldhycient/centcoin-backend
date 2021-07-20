<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/admin.php";

$admin = new admin();

if(!empty($_POST["userid"]) && !empty($_POST["amount"]) && !empty($_POST["packages"])  ){
   echo  $admin::makeDeposit($_POST["userid"],$_POST["amount"],$_POST["packages"]);
}
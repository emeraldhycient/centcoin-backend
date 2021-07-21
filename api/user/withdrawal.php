<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/user.php";

$user = new users();

if(!empty($_POST["userid"]) && !empty($_POST["wallet"]) && !empty($_POST["amount"])  ){
  echo  $user::makeWithdrawal($_POST["userid"],$_POST["wallet"],$_POST["amount"]);
}
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/user.php";

$user = new users();

if(!empty($_POST["userid"]) && !empty($_POST["bankname"]) &&  !empty($_POST["routingnumber"]) &&  !empty($_POST["accountname"]) &&  
!empty($_POST["accountnumber"]) &&  !empty($_POST["amount"]) ){
  echo  $user::makeWithdrawal($_POST["userid"],$_POST["bankname"],$_POST["routingnumber"],$_POST["accountname"],$_POST["accountnumber"],$_POST["amount"]);
}
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "../../models/admin.php";

$admin = new admin();

if(isset($_GET["all"])){
     echo $admin::paymentmethods();
}

if(isset($_POST["update"])){
    if(
        !empty($_POST["id"]) &&  !empty($_POST["bitcoin"]) &&  !empty($_POST["ethereum"]) && 
         !empty($_POST["litecoin"]) &&  !empty($_POST["paypal"]) &&  !empty($_POST["venmo"]) &&  !empty($_POST["zelle"]) ){
        echo $admin::updatepaymentmethods($_POST["id"],$_POST["bitcoin"],$_POST["ethereum"],$_POST["litecoin"],$_POST["paypal"],
        $_POST["venmo"],$_POST["zelle"]);
    }
}
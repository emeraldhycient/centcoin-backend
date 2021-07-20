<?php

include "../../config/config.php";

class users extends Connection{

    public static function createaccount($fullname,$username,$password,$email,$country,$plan,$currency,$referredby,$isadmin)
    {
        $userid = uniqid();
        $fullname = self::filter($fullname);
        $username = self::filter($username);
        $password = self::filter($password);
        //$hashpassword = password_hash($password,PASSWORD_BCRYPT);
        $email = self::filter($email);
        $country = self::filter($country);
        $plan = self::filter($plan);
        $country = self::filter($currency);

        $sql = "INSERT INTO users (userid,fullname,username,pass,email,country,plans,currency,referredby,isAdmin) VALUES 
        (?,?,?,?,?,?,?,?,?,?)";
        $query = self::$connect->prepare($sql);
        $query->bind_param("ssssssssss",$userid,$fullname,$username,$password,$email,$country,$plan,$currency,$referredby,$isadmin);
        $query->execute();
        if($query->affected_rows >0){
            return self::Response(200,'success',"signup successfully",'');
        }else{
             return self::Response(200,'failed',"unable to signup user".$query->error,'');
        }

    }

    public static  function makeWithdrawal($userid,$bankname,$routingnumber,$accountname,$accountnumber,$amount)
    {
        $bankname = self::filter($bankname);
        $routingnumber = self::filter($routingnumber);
        $accountname = self::filter($accountname);
        $accountnumber = self::filter($accountnumber);
        $amount = self::filter($amount);
        $userid = self::filter($userid);

        $sql = "INSERT INTO withdrawal (userid,bankname,routing,accountname,accountnumber,amount) VALUES (?,?,?,?,?,?)";
        $query = self::$connect->prepare($sql);
        $query->bind_param("ssisii",$userid,$bankname,$routingnumber,$accountname,$accountnumber,$amount);
        $query->execute();
        if($query->affected_rows > 0){
            return self::Response(200,"success","withdrawal placed successfully",'');
        }else{
            return self::Response(500,"failed","no unable to place withdrawal",'');
        }

    }

    public static function paymentMethods()
    {
        $data = [];
        $sql = "SELECT * FROM paymentmethod";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows > 0){
           while($row = $result->fetch_object()){
               $data=[
                'id' => $row->id,
                'bitcoin' => $row->bitcoin,
                'ethereum' => $row->ethereum,
                'litecoin' => $row->litecoin,
                'paypal' => $row->paypal,
                'venmo' => $row->venmo,
                'zelle' => $row->zelle
               ];
            }
            return self::Response(200,"success","paymentmethods fouund",$data);
            }else{
                return self::Response(404,"failed","no paymentmethods found",'');
            }  

     }

    public static function allTransactions($userid)
    {
        $data = [];
        $sql = "SELECT * FROM deposit FULL OUTER JOIN ON withdrawal deposit.userid = withdrawal.userid WHERE userid = ?";
        $query = self::$connect->prepare($sql);
        $query->bind_param('s',$userid);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_object()){
                  $data['transactions'][$row->id] = [
                          $row
                      ];
                    }
                    return self::Response(200,'success','transactions found',$data);
        }else{
            return self::Response(404,'failed','no transactions found',''); 
        }

    }

    public static function totalDeposit($userid)
    {
         $sql = "SELECT SUM(amount) as amount FROM  deposit WHERE userid = '$userid' ";
         $query = self::$connect->query($sql);
         $data = $query->fetch_array();
         if($data){
            return self::Response(200,"success","woolah",$data);
         }else{
            return self::Response(404,"failed","nothing found",$data);
         }

    }

    public static function message($email,$name,$message)
    {
        $name =self::filter($name);
        $email =self::filter($email);
        $message =self::filter($message);
        
        $sql = "INSERT INTO messages (email,fullname,messages) VALUES (?,?,?)";
        $query = self::$connect->prepare($sql);
        $query->bind_param('sss',$email,$name,$message);
        $query->execute();
        if($query->affected_rows > 0){
            return self::Response(200,"success","message  sent","");
        }else{
            return self::Response(500,"failed","message wasnt sent","");
        }

    }

  
}
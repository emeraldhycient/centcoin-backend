<?php

include "../../config/config.php";

class Auth extends Connection{
    public static  function Login($email,$password)
    {
        $email = self::filter($email);
        $password = self::filter($password);
        $sql = "SELECT * FROM users WHERE email = ? ";
        $query = self::$connect->prepare($sql);
        $query->bind_param('s',$email);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows > 0){
             while($row = $result->fetch_object()){
                 //if(password_verify($password,$row->pass)){
                   if($password === $row->pass){
                       $hash = uniqid().$row->userid;
                       $_SESSION["hash"] = $hash;
                       $_SESSION["userid"] = $row->userid;
                        $data["user"] = [
                            'userid'=> $row->userid,
                            'isadmin'=> (boolean)$row->isAdmin,
                            'username' => $row->username,
                            'email' => $row->email
                        ] ;
                        $data['hash'] = $hash;
                        return self::Response(200,'success','login successful',$data);
                 }else{
                    return self::Response(403,'failed','incorrect password. check the email or password','');
                 }
             }
        }else{
            return self::Response(404,'failed','no user found. check the email','');
        }


    }

    public  static function userdetails($hash,$userid){

            $sql = "SELECT * FROM users WHERE userid = ? ";
            $query = self::$connect->prepare($sql);
            $query->bind_param('s',$userid);
            $query->execute();
            $result = $query->get_result();
            if($result->num_rows > 0){
                 while($row = $result->fetch_object()){
                          
                            $data["user"] = [
                                'userid'=> $row->userid,
                                'isadmin'=> (boolean)$row->isAdmin,
                                'fullname' => $row->fullname,
                                'username' => $row->username,
                                'email' => $row->email,
                                'country' => $row->country,
                                'plan'=> $row->plans,
                                'accountbalance' => $row->accountbalance,
                                'currency' => $row->currency,
                                'createdAt' => $row->createdAt
                            ] ;
                            return self::Response(200,'success','',$data);
                 }
            }else{
                return self::Response(404,'failed','no user found','');
            }
      
    }


    public static function updatesettings($userid,$username,$email,$password)
    {
        $sql = "UPDATE users SET username=?, email = ? , pass =? WHERE userid =?";
        $query= self::$connect->prepare($sql);
        $query->bind_param('ssss',$username,$email,$password,$userid);
        $query->execute();
        if($query->affected_rows > 0){
            return self::Response(200,'success','details updated successfully','');
        }else{
            return self::Response(500,'failed',"unable to update details",'');
        }

    }


}
<?php

include "../../config/config.php";

class users extends Connection
{

    public static function createaccount($fullname, $username, $password, $email, $country, $plan, $currency, $referredby, $isadmin)
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
        $query->bind_param("ssssssssss", $userid, $fullname, $username, $password, $email, $country, $plan, $currency, $referredby, $isadmin);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, 'success', "signup successfully", '');
        } else {
            return self::Response(200, 'failed', "unable to signup user" . $query->error, '');
        }
    }

    public static function updateuser($userid, $fullname, $username, $password, $email, $accountbalance, $plan, $currency, $isadmin, $status)
    {
        $fullname = self::filter($fullname);
        $username = self::filter($username);
        $password = self::filter($password);
        //$hashpassword = password_hash($password,PASSWORD_BCRYPT);
        $email = self::filter($email);
        $plan = self::filter($plan);
        $country = self::filter($currency);

        $sql = "UPDATE users SET fullname = ? ,username = ?,pass= ?,email =?,accountbalance = ?,plans = ?,currency = ?,isAdmin = ? ,statuz =? WHERE userid =?";
        $query = self::$connect->prepare($sql);
        $query->bind_param("ssssisssss", $fullname, $username, $password, $email, $accountbalance, $plan, $currency, $isadmin, $status, $userid);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, 'success', "user update  successfully", '');
        } else {
            return self::Response(500, 'failed', "unable to update user" . $query->error, '');
        }
    }

    public static  function makeWithdrawal($userid, $wallet, $amount)
    {

        $sql = "INSERT INTO withdrawal (userid,wallet,amount) VALUES (?,?,?)";
        $query = self::$connect->prepare($sql);
        $query->bind_param("ssi", $userid, $wallet, $amount);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, "success", "withdrawal placed successfully", '');
        } else {
            return self::Response(500, "failed", "no unable to place withdrawal", '');
        }
    }

    public static function paymentMethods()
    {
        $data = [];
        $sql = "SELECT * FROM paymentmethod";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data = [
                    'id' => $row->id,
                    'bitcoin' => $row->bitcoin,
                    'ethereum' => $row->ethereum,
                    'litecoin' => $row->litecoin,
                    'paypal' => $row->paypal,
                    'venmo' => $row->venmo,
                    'zelle' => $row->zelle
                ];
            }
            return self::Response(200, "success", "paymentmethods fouund", $data);
        } else {
            return self::Response(404, "failed", "no paymentmethods found", '');
        }
    }

    public static function allTransactions($userid)
    {
        $data = [];
        $sql = "SELECT * FROM deposit FULL OUTER JOIN ON withdrawal deposit.userid = withdrawal.userid WHERE userid = ?";
        $query = self::$connect->prepare($sql);
        $query->bind_param('s', $userid);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data['transactions'][$row->id] = [
                    $row
                ];
            }
            return self::Response(200, 'success', 'transactions found', $data);
        } else {
            return self::Response(404, 'failed', 'no transactions found', '');
        }
    }

    public static function totalDeposit($userid)
    {
        $sql = "SELECT SUM(amount) as amount FROM  deposit WHERE userid = '$userid' ";
        $query = self::$connect->query($sql);
        $data = $query->fetch_array();
        if ($data) {
            return self::Response(200, "success", "woolah", $data);
        } else {
            return self::Response(404, "failed", "nothing found", $data);
        }
    }

    public static function message($email, $name, $message)
    {
        $name = self::filter($name);
        $email = self::filter($email);
        $message = self::filter($message);

        $sql = "INSERT INTO messages (email,fullname,messages) VALUES (?,?,?)";
        $query = self::$connect->prepare($sql);
        $query->bind_param('sss', $email, $name, $message);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, "success", "message  sent", "");
        } else {
            return self::Response(500, "failed", "message wasnt sent", "");
        }
    }

    public static function Profits()
    {
        $data = [];
        //select all users 
        $sql = "SELECT * FROM users ";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        while ($row = $result->fetch_object()) {
            //check account balance if theres any investment
            if ($row->accountbalance > 0) {
                $plan = strtoupper($row->plans);
                // so theres investment go ahead and select the duration , amount ,
                $sql2 = "SELECT * FROM packages WHERE plan =?";
                $query2 = self::$connect->prepare($sql2);
                $query2->bind_param('s', $plan);
                $query2->execute();
                $result2 = $query2->get_result();
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_object()) {
                        // check the duration table if the users package duration has been achieved or if him/her is new
                        $sql3 = "SELECT * FROM durations WHERE userid =?";
                        $query3 = self::$connect->prepare($sql3);
                        $query3->bind_param('s', $row->userid);
                        $query3->execute();
                        $result3 = $query3->get_result();
                        if ($result3->num_rows > 0) {
                            while ($row3 = $result3->fetch_object()) {
                                if ((int)$row2->duration > (int)$row3->numDays) {
                                    $days = (int)$row3->numDays + 1;
                                    $sql4 = "UPDATE durations SET numDays =? WHERE userid = ?";
                                    $query4 = self::$connect->prepare($sql4);
                                    $query4->bind_param('is', $days, $row->userid);
                                    $query4->execute();
                                    if ($query4->affected_rows > 0) {
                                        echo "updated <br/>";
                                    } else {
                                        echo $query4->error;
                                    }
                                } elseif ((int)$row2->duration === (int)$row3->numDays) {
                                    $price = $row2->mindep;
                                    $percent = $row2->percentages;
                                    $profit = (($percent / 100) * $price);
                                    $newbal = $row->accountbalance + $profit;
                                    $sql5 = "UPDATE users SET accountbalance = ? WHERE userid = ?";
                                    $query5 = self::$connect->prepare($sql5);
                                    $query5->bind_param("is", $newbal, $row->userid);
                                    $query5->execute();
                                    if ($query5->affected_rows > 0) {
                                        $days = (int)$row3->numDays + 1;
                                        $sql4 = "UPDATE durations SET numDays =? WHERE userid = ?";
                                        $query4 = self::$connect->prepare($sql4);
                                        $query4->bind_param('is', $days, $row->userid);
                                        $query4->execute();
                                        if ($query4->affected_rows > 0) {
                                            echo " $newbal <br/>";
                                        } else {
                                            echo $query4->error;
                                        }
                                    } else {
                                        echo $query5->error;
                                    }
                                } else {
                                    echo "nothing to do ";
                                }
                            }
                        } else {
                            $numdays = 1;
                            $sqlx = "INSERT INTO  durations(userid,numDays) VALUES (?,?)";
                            $queryx = self::$connect->prepare($sqlx);
                            $queryx->bind_param('si', $row->userid, $numdays);
                            $queryx->execute();
                            if ($queryx->affected_rows > 0) {
                                echo "user insert successful<p>";
                            }
                        }
                    }
                } else {
                    echo $query2->error;
                }
            }
        }
    }
}
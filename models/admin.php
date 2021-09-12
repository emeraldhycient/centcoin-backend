<?php

include_once('../../config/config.php');

class admin extends Connection
{

    public static function users()
    {
        $data = [];
        $sql = "SELECT * FROM users";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data["users"][$row->id] = [
                    'userid' => $row->userid,
                    'isadmin' => (bool)$row->isAdmin,
                    'fullname' => $row->fullname,
                    'username' => $row->username,
                    'status' => $row->statuz,
                    'email' => $row->email,
                    'country' => $row->country,
                    'password' => $row->pass,
                    'plan' => $row->plans,
                    'referredby' => $row->referredby,
                    'accountbalance' => (float)$row->accountbalance,
                    'currency' => $row->currency,
                    'createdAt' => $row->createdAt
                ];
            }
            return self::Response(200, "success", "users found", $data);
        } else {
            return self::Response(404, "failed", "no user found", '');
        }
    }

    public static function Deposits()
    {
        $data = [];
        $sql = "SELECT * FROM deposit";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data["deposits"][$row->id] = [
                    'userid' => $row->userid,
                    'package' => $row->package,
                    'amount' => $row->amount,
                    'status' => $row->statuz,
                    'createdAt' => $row->createdAt
                ];
            }
            return self::Response(200, "success", "deposits fouund", $data);
        } else {
            return self::Response(404, "failed", "no deposit found", '');
        }
    }

    public static function updatebalance($amount, $userid)
    {
        $sql = "SELECT * FROM users WHERE userid=?";
        $query = self::$connect->prepare($sql);
        $query->bind_param('s', $userid);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $accountbalance  = (int)$row->accountbalance + $amount;
                $sql2 = "UPDATE users SET accountbalance = ? WHERE userid = ?";
                $query2 = self::$connect->prepare($sql2);
                $query2->bind_param('is', $accountbalance, $userid);
                $query2->execute();
                if ($query->affected_rows > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function makeDeposit($userid, $amount, $package)
    {
        $userid = self::filter($userid);
        $amount = self::filter($amount);
        $package = self::filter($package);
        $sql = "INSERT INTO deposit (userid,package,amount) VALUES (?,?,?)";
        $query = self::$connect->prepare($sql);
        $query->bind_param('ssi', $userid, $package, $amount);
        $query->execute();
        if ($query->affected_rows > 0) {
            if (self::updatebalance($amount, $userid)) {
                return self::Response(200, 'success', ' deposit made successfully', '');
            } else {
                return self::Response(500, 'failed', 'unable to make deposit', '');
            }
        } else {
            return self::Response(500, 'failed', 'unable to make deposit', '');
        }
    }

    public static function depositstatus($statuz, $id)
    {
        $status = self::filter($statuz);
        $id = self::filter($id);
        $sql = "UPDATE deposit SET statuz = ? WHERE id = ?";
        $query = self::$connect->prepare($sql);
        $query->bind_param('si', $status, $id);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, 'success', 'status updated ', '');
        } else {
            return self::Response(500, "failed", "unable to update status", "");
        }
    }

    public static function withdrawals()
    {
        $data = [];
        $sql = "SELECT * FROM withdrawal";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data["withdrawal"][$row->id] = [
                    'userid' => $row->userid,
                    'wallet' => $row->wallet,
                    'amount' => $row->amount,
                    'status' => $row->statuz,
                    'createdAt' => $row->createdAt
                ];
            }
            return self::Response(200, "success", "withdrawals fouund", $data);
        } else {
            return self::Response(404, "failed", "no withdrawal found", '');
        }
    }

    public static function unprocessedwithdrawals()
    {
        $data = [];
        $sql = "SELECT * FROM withdrawal WHERE statuz = 'pending'";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data["withdrawal"][$row->id] = [
                    'userid' => $row->userid,
                    'wallet' => $row->wallet,
                    'amount' => $row->amount,
                    'status' => $row->statuz,
                    'createdAt' => $row->createdAt
                ];
            }
            return self::Response(200, "success", "withdrawals fouund", $data);
        } else {
            return self::Response(404, "failed", "no unprocessed withdrawal found", '');
        }
    }

    public static function debit($amount, $userid)
    {
        $sql = "SELECT * FROM users WHERE userid=?";
        $query = self::$connect->prepare($sql);
        $query->bind_param('s', $userid);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $accountbalance  = (int)$row->accountbalance - $amount;
                $sql2 = "UPDATE users SET accountbalance = ? WHERE userid = ?";
                $query2 = self::$connect->prepare($sql2);
                $query2->bind_param('is', $accountbalance, $userid);
                $query2->execute();
                if ($query->affected_rows > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function processwithdrawal($statuz, $userid, $amount)
    {
        $status = self::filter($statuz);
        $userid = self::filter($userid);
        $sql = "UPDATE withdrawal SET statuz = ? WHERE userid = ?";
        $query = self::$connect->prepare($sql);
        $query->bind_param('ss', $status, $userid);
        $query->execute();
        if ($query->affected_rows > 0) {
            if (self::debit($amount, $userid)) {
                $sql2 = "DELETE FROM durations WHERE userid = ?";
                $query2 = self::$connect->prepare($sql2);
                $query2->bind_param("s", $userid);
                $query2->execute();
                if ($query2->affected_rows > 0) {
                    return self::Response(200, 'success', 'withdrawal processed ', '');
                } else {
                    return self::Response(500, "failed", "unable to process withdrawal because this user doesnt have earning record", "");
                }
            } else {
                return self::Response(500, "failed", "unable to process withdrawal", "");
            }
        } else {
            return self::Response(500, "failed", "unable to process withdrawal", "");
        }
    }

    public static function packages()
    {
        $data = [];
        $sql = "SELECT * FROM packages";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[$row->id] = [
                    'plan' => $row->plan,
                    'duration' => $row->duration,
                    'percentage' => $row->percentages,
                    'mindep' => $row->mindep,
                    'maxdep' => $row->maxdep
                ];
            }
            return self::Response(200, "success", "packages fouund", $data);
        } else {
            return self::Response(404, "failed", "no packages found", '');
        }
    }

    public static function updatePackage($id, $plan, $duration, $percentage, $mindep, $maxdep)
    {
        $id = self::filter($id);
        $plan = self::filter($plan);
        $duration = self::filter($duration);
        $percentage = self::filter($percentage);
        $mindep = self::filter($mindep);
        $maxdep = self::filter($maxdep);

        $sql = "UPDATE packages SET plan = ? ,duration = ? ,percentages = ?,mindep = ? ,maxdep =? WHERE id =? ";
        $query = self::$connect->prepare($sql);
        $query->bind_param("sisssi", $plan, $duration, $percentage, $mindep, $maxdep, $id);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, "success", "package update successfull", '');
        } else {
            return self::Response(500, "failed", "unable to update package", '');
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

    public static function updatepaymentmethods($id, $bitcoin, $ethereum, $litecoin, $paypal, $venmo, $zelle)
    {
        $bitcoin = self::filter($bitcoin);
        $ethereum = self::filter($ethereum);
        $litecoin = self::filter($litecoin);
        $paypal = self::filter($paypal);
        $venmo = self::filter($venmo);
        $zelle  = self::filter($zelle);

        $sql = "UPDATE paymentmethod SET bitcoin = ? , ethereum = ? ,litecoin = ?, paypal = ? , venmo = ? , zelle = ? WHERE id =?";
        $query = self::$connect->prepare($sql);
        $query->bind_param("ssssssi", $bitcoin, $ethereum, $litecoin, $paypal, $venmo, $zelle, $id);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, "success", "payment methods updated", '');
        } else {
            return self::Response(500, "failed", "unable to  update payment methods ", '');
        }
    }

    public static function messages()
    {
        $data = [];
        $sql = "SELECT * FROM messages";
        $query = self::$connect->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[$row->id] = [
                    'name' => $row->fullname,
                    'email' => $row->email,
                    'message' => $row->messages,
                    'createdAt' => $row->createdAt
                ];
            }
            return self::Response(200, "success", "messages fouund", $data);
        } else {
            return self::Response(404, "failed", "no messages found", '');
        }
    }

    public static function totalDeposit()
    {
        $sql = "SELECT SUM(amount) as amount FROM  deposit";
        $query = self::$connect->query($sql);
        $data = $query->fetch_array();
        if ($data) {
            return self::Response(200, "success", "woolah", $data);
        } else {
            return self::Response(404, "failed", "nothing found", $data);
        }
    }

    public static function totalusers()
    {
        $sql = "SELECT COUNT(*) as users FROM  users";
        $query = self::$connect->query($sql);
        $data = $query->fetch_array();
        if ($data) {
            return self::Response(200, "success", "woolah", $data);
        } else {
            return self::Response(404, "failed", "nothing found", $data);
        }
    }

    public static function deleteuser($userid)
    {
        $sql = " DELETE FROM users  WHERE userid = ?";
        $query = self::$connect->prepare($sql);
        $query->bind_param("s", $userid);
        $query->execute();
        if ($query->affected_rows > 0) {
            return self::Response(200, "success", "user deleted successfully", '');
        } else {
            return self::Response(500, "failed", "unable to delete user" . $query->error, '');
        }
    }

    public  static function userdetails($hash, $userid)
    {

        $sql = "SELECT * FROM users WHERE userid = ? ";
        $query = self::$connect->prepare($sql);
        $query->bind_param('s', $userid);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {

                $data["user"] = [
                    'userid' => $row->userid,
                    'isadmin' => (bool)$row->isAdmin,
                    'fullname' => $row->fullname,
                    'username' => $row->username,
                    'email' => $row->email,
                    'country' => $row->country,
                    'password' => $row->pass,
                    'status' => $row->statuz,
                    'plan' => $row->plans,
                    'accountbalance' => $row->accountbalance,
                    'currency' => $row->currency,
                    'createdAt' => $row->createdAt
                ];
                return self::Response(200, 'success', '', $data);
            }
        } else {
            return self::Response(404, 'failed', 'no user found', '');
        }
    }
}
<?php

class Edituser_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey=$key_login[0];
            $Pkey=$key_login[1];
            $query = $this->db->prepare("select * from setting where adminuser='" .$Ukey. "' and login_key='" .$_COOKIE["xpkey"]. "'");
            $query->execute();
            $queryCount = $query->rowCount();
            $query_ress = $this->db->prepare("select * from admins where username_u='" . $Ukey . "' and login_key='" . $_COOKIE["xpkey"] . "'");
            $query_ress->execute();
            $queryCount_ress = $query_ress->rowCount();
            if ($queryCount >0) {
                define('permis','admin');
            }
            if ($queryCount_ress >0) {
                define('permis','reseller');
            }
            if ($queryCount == 0 && $queryCount_ress == 0) {
                header("location: login");
            }
        } else {
            header("location: login");
        }
    }

    public function user($data_sybmit)
    {
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where=''; } else{$where=" and customer_user='$Ukey' ";}
        $query = $this->db->prepare("select * from users  WHERE username='".$data_sybmit['username']."' $where");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
    public function submit_update($data_sybmit)
    {
        $password=$data_sybmit['password'];
        $email=$data_sybmit['email'];
        $username=$data_sybmit['username'];
        $mobile=$data_sybmit['mobile'];
        $multiuser=$data_sybmit['multiuser'];
        $traffic=$data_sybmit['traffic'];
        $info=$data_sybmit['info'];
        $activate=$data_sybmit['activate'];
        if(LANG=='fa-ir') {
            if (!empty($data_sybmit['finishdate'])) {
                $finishdate = explode('/', $data_sybmit['finishdate']);
                $finishdate = jalali_to_gregorian($finishdate[0], $finishdate[1], $finishdate[2], '-');
                $finishdate = explode('-', $finishdate);
                if($finishdate[1]<10)
                {$m='0'.$finishdate[1];} else { $m=$finishdate[1];}
                if($finishdate[2]<10)
                {$d='0'.$finishdate[2];} else { $d=$finishdate[2];}
                $finishdate=$finishdate[0].'-'.$m.'-'.$d;
            } else {
                $finishdate = '';
            }
        }
        else{
            $finishdate = $data_sybmit['finishdate'];
        }
        $data = [
            'password'=>$password,
            'email' => $email,
            'mobile' => $mobile,
            'multiuser' => $multiuser,
            'finishdate' => $finishdate,
            'traffic' => $traffic,
            'info' => $info,
            'username' => $username,
            'activate' => $activate
        ];

        $sql = "UPDATE users SET password=:password, email=:email,mobile=:mobile,multiuser=:multiuser,finishdate=:finishdate,enable=:activate,traffic=:traffic,info=:info WHERE username=:username ";

        $statement = $this->db->prepare($sql);

        if($statement->execute($data)) {
            shell_exec("sudo killall -u " . $username);
            shell_exec("bash Libs/sh/changepass ".$username." ".$password);

            if($activate=='true')
            {
                shell_exec("sudo killall -u " . $username);
                shell_exec("bash Libs/sh/adduser " . $username . " " . $password);
            }
            else
            {
                $dropbear = shell_exec("ps aux | grep -i dropbear | awk '{print $2}'");
                $dropbear = preg_split("/\r\n|\n|\r/", $dropbear);
                foreach ($dropbear as $pid) {

                    $num_drop = shell_exec("cat /var/log/auth.log | grep -i dropbear | grep -i \"Password auth succeeded\" | grep \"dropbear\[$pid\]\" | wc -l");
                    $user_drop = shell_exec("cat /var/log/auth.log | grep -i dropbear | grep -i \"Password auth succeeded\" | grep \"dropbear\[$pid\]\" | awk '{print $10}'");
                    $user_drop=str_replace("'", "",$user_drop);
                    $user_drop=str_replace("\n", "",$user_drop);
                    $user_drop = htmlentities($user_drop);

                    if ($user_drop==$username) {

                        shell_exec("sudo kill -9 " . $pid);
                    }
                }
                shell_exec("sudo killall -u " . $username);
                shell_exec("bash Libs/sh/userdelete " . $username);
            }
            header("Refresh:0");

        }
    }

    function en_number($number)
    {

        $en = array("0","1","2","3","4","5","6","7","8","9");
        $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
        return str_replace($fa,$en, $number);
    }
}

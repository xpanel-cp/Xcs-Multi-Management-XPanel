<?php

class Edituser_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey=$key_login[0];
            $Pkey=$key_login[1];
            $query = $this->db->prepare("select * from setting where adminuser='" .$Ukey. "' and login_key='" .$_COOKIE["xcskey"]. "'");
            $query->execute();
            $queryCount = $query->rowCount();
            $query_ress = $this->db->prepare("select * from admins where username_u='" . $Ukey . "' and login_key='" . $_COOKIE["xcskey"] . "'");
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
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
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
        $password = $data_sybmit['password'];
        $email = $data_sybmit['email'];
        $username = $data_sybmit['username'];
        $mobile = $data_sybmit['mobile'];
        $multiuser = $data_sybmit['multiuser'];
        $traffic = $data_sybmit['traffic'];
        $info = $data_sybmit['info'];
        $activate = $data_sybmit['activate'];
        $change_server = $data_sybmit['change_server'];
        if (LANG == 'fa-ir') {
            if (!empty($data_sybmit['finishdate'])) {
                $finishdate = explode('/', $data_sybmit['finishdate']);
                $finishdate = jalali_to_gregorian($finishdate[0], $finishdate[1], $finishdate[2], '-');
                $finishdate = explode('-', $finishdate);
                if ($finishdate[1] < 10) {
                    $m = '0' . $finishdate[1];
                } else {
                    $m = $finishdate[1];
                }
                if ($finishdate[2] < 10) {
                    $d = '0' . $finishdate[2];
                } else {
                    $d = $finishdate[2];
                }
                $finishdate = $finishdate[0] . '-' . $m . '-' . $d;
            } else {
                $finishdate = '';
            }
        } else {
            $finishdate = $data_sybmit['finishdate'];
        }

        $query = $this->db->prepare("select * from users where username='" . $username . "'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
            $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
            $query->execute();
            $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
            // set post fields
            $post = [
                'username' => $username,
                'password' => $password,
                'multiuser' => $multiuser,
                'traffic' => $traffic,
                'type_traffic' => 'mb',
                'expdate' => $finishdate
            ];

            $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=edituser');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            if ($response['data'] == 'Success Edit User') {
                $data = [
                    'password' => $password,
                    'email' => $email,
                    'mobile' => $mobile,
                    'multiuser' => $multiuser,
                    'finishdate' => $finishdate,
                    'traffic' => $traffic,
                    'info' => $info,
                    'username' => $username,
                    'activate' => $activate,
                    'change_server' => $change_server
                ];

                $sql = "UPDATE users SET password=:password, email=:email,mobile=:mobile,multiuser=:multiuser,finishdate=:finishdate,enable=:activate,traffic=:traffic,info=:info,change_server=:change_server WHERE username=:username ";

                $statement = $this->db->prepare($sql);
                $statement->execute($data);
                if($activate=='true')
                {
                    $post = [
                        'username' => $username
                    ];

                    $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=activeuser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_exec($ch);
                    curl_close($ch);
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

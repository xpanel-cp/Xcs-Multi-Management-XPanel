<?php

class Api_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function check_token($data)
    {
        $ipremote= $_SERVER['REMOTE_ADDR'];
        $query = $this->db->prepare("select * from ApiToken where Token='$data' and enable='true' and Allowips='$ipremote'");
        $query->execute();
        $queryCount = $query->rowCount();
        if($queryCount>0)
        {
            $access='allowed';
        }
        else{
            $access='illegal';
        }
        return $access;
    }
    public function list_user()
    {
        $query = $this->db->prepare("select * from users");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function status_user($data)
    {
        $query = $this->db->prepare("select * from users where enable='$data'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }

    public function show_user($data)
    {
        $query = $this->db->prepare("select * from users where username='$data'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function edit_user($data_sybmit)
    {
        $password=$data_sybmit['password'];
        $email=$data_sybmit['email'];
        $username=$data_sybmit['username'];
        $mobile=$data_sybmit['mobile'];
        $multiuser=$data_sybmit['multiuser'];
        $traffic=$data_sybmit['traffic'];
        $info=$data_sybmit['info'];
        $finishdate = $data_sybmit['finishdate'];
        $data = [
            'password'=>$password,
            'email' => $email,
            'mobile' => $mobile,
            'multiuser' => $multiuser,
            'finishdate' => $finishdate,
            'traffic' => $traffic,
            'info' => $info,
            'username' => $username
        ];

        $sql = "UPDATE users SET password=:password, email=:email,mobile=:mobile,multiuser=:multiuser,finishdate=:finishdate,traffic=:traffic,info=:info WHERE username=:username";

        $statement = $this->db->prepare($sql);

        if($statement->execute($data)) {
            shell_exec("sudo killall -u " . $username);
            shell_exec("bash Libs/sh/changepass ".$username." ".$password);
            echo json_encode(['ststus' => 200 , 'data'=>'Success Edit User' ]);
            return true;
        }
    }

    public function submit_index($data_sybmit)
    {
        //print_r($data_sybmit);
        if(empty($data_sybmit['password']))
        {
            if($data_sybmit['pass_rand']=='number')
            {
                $chars = "1234567890";
            }
            else
            {
                $chars = "abcdefghijklmnopqrstuvwxyz1234567890";
            }
            $password = substr( str_shuffle( $chars ), 0, $data_sybmit['pass_char'] );
        }
        else
        {
            $password=$data_sybmit['password'];
        }
        $query = $this->db->prepare("select * from users where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->rowCount();
        if ($queryCount < 1) {

                $finishdate = $data_sybmit['finishdate'];

            $sql = "INSERT INTO `users` (`username`, `password`, `email`, `mobile`, `multiuser`, `startdate`, `finishdate`, `finishdate_one_connect`,`customer_user`, `enable`, `traffic`, `referral`, `info`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($data_sybmit['username'], $password, $data_sybmit['email'], $data_sybmit['mobile'], $data_sybmit['multiuser'], $data_sybmit['startdate'], $finishdate, $data_sybmit['finishdate_one_connect'],'API', $data_sybmit['enable'], $data_sybmit['traffic'], $data_sybmit['referral'], $data_sybmit['info']));
            if ($stmt) {
                $sql = "INSERT INTO `Traffic` (`id`,`user`, `download`, `upload`, `total` ) VALUES (NULL,?,?,?,?)";
                $stmt = $this->db->prepare($sql);
                $use_traffic=$data_sybmit['username'];
                $stmt->execute(array($use_traffic, '0', '0', '0'));
                $stmt = $this->db->prepare("SELECT * FROM Traffic WHERE user=:user");
                $stmt->execute(['user' => $use_traffic]);
                $user = $stmt->rowCount();
                if($user==0) {
                    $sql1 = "INSERT INTO `Traffic` (`user`, `download`, `upload`, `total` ) VALUES (?,?,?,?)";
                    $stmt1 = $this->db->prepare($sql1);
                    $stmt1->execute(array($use_traffic, '0', '0', '0'));
                }
                shell_exec("bash Libs/sh/adduser " . strtolower($data_sybmit['username']) . " " . $password);
                echo json_encode(['ststus' => 200 , 'data'=>'User Created' ]);
                return true;
            } else {
                return false;
                echo json_encode(['ststus' => 400 , 'data'=>'Unkon Error' ]);
            }
        } else {
            echo json_encode(['ststus' => 400 , 'data'=>'User Exist' ]);
        }
    }


    public function delete_user($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $query = $this->db->prepare("DELETE FROM users WHERE username=?")->execute([$username]);
        $this->db->prepare("DELETE FROM Traffic WHERE user=?")->execute([$username]);
        if($query)
        {
            shell_exec("sudo killall -u " . $username);
            shell_exec("sudo userdel -r " . $username);
            echo json_encode(['ststus' => 200 , 'data'=>'User Deleted' ]);
        }
    }

}

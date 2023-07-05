<?php

class Users_Model extends Model
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

    public function users()
    {
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where='';} else{$where=" and users.customer_user='$Ukey' ";}
        $query = $this->db->prepare("select *,servers.name from users,Traffic,servers where users.username=Traffic.user and servers.id=users.server $where ORDER BY users.id DESC");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
    public function Get_permis()
    {
        $query = permis;
        return $query;
    }
    public function Get_settings()
    {
        $query = $this->db->prepare("select * from setting");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
    public function index_server()
    {
        $query = $this->db->prepare("select * from servers");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function index_package()
    {
        $query = $this->db->prepare("select package.*,servers.name from package,servers where package.server=servers.id ORDER BY package.id DESC");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }
    public function change_server($data_submit)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:user");
        $stmt->execute(['user' => $data_submit['username']]);
        $user = $stmt->fetch();

        $old_server = $this->db->prepare("SELECT * FROM servers WHERE id=:id");
        $old_server->execute(['id' => $user['server']]);
        $old_server = $old_server->fetch();

        $server = $this->db->prepare("SELECT * FROM servers WHERE id=:id");
        $server->execute(['id' => $data_submit['server']]);
        $server = $server->fetch();

        if($user['server']!=$data_submit['server']) {
            $username = $data_submit['username'];
            if (1024 < $user['traffic']) {
                $type_traffic ='gb';
            } else {
                $type_traffic ='mb';
            }
            $post = [
                'username' => $user['username']
            ];

            $ch = curl_init($old_server['link'] . '/api&key=' . $old_server['token'] . '&method=deleteuser');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            if ($response['data']=='User Deleted')
            {
            // set post fields
            $post = [
                'username' => $user['username'],
                'password' => $user['password'],
                'multiuser' => $user['multiuser'],
                'traffic' => $user['traffic'],
                'type_traffic' => $type_traffic,
                'expdate' => $user['finishdate']
            ];

            $ch = curl_init($server['link'] . '/api&key=' . $server['token'] . '&method=adduser');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            if ($response['data']=='User Created') {
                $sql = "UPDATE users SET server=? WHERE username=?";
                $this->db->prepare($sql)->execute([$data_submit['server'], $username]);
                header("Location: users");
            }
            if ($response['data']=='User Exist') {
                echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.user_change_server_rep_lang.'</div>
              </div>
            </div>';
            }
        }
        else
        {
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.user_change_server_error_lang.'</div>
              </div>
            </div>';
        }
        }
    }
    public function submit_ative($data_sybmit)
    {
        $query = $this->db->prepare("select * from users where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $post = [
            'username' => $data_sybmit['username']
        ];

        $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=activeuser');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        if ($response['data']=='User Actived') {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username=:user");
            $stmt->execute(['user' => $data_sybmit['username']]);
            $user = $stmt->fetch();
            $username = $data_sybmit['username'];
            $sql = "UPDATE users SET enable=? WHERE username=?";
            $this->db->prepare($sql)->execute(['true', $username]);
            header("Location: users");
        }
    }
    public function submit_deative($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $query = $this->db->prepare("select * from users where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $post = [
            'username' => $data_sybmit['username']
        ];

        $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=deactiveuser');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        if ($response['data']=='User Deactived') {
            $sql = "UPDATE users SET enable=? WHERE username=?";
            $this->db->prepare($sql)->execute(['false', $username]);
            header("Location: users");
        }
    }
    public function submit_index($data_sybmit)
    {
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
        }
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
            $query = $this->db->prepare("select * from servers where id=" . $data_sybmit['id_server']);
            $query->execute();
            $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);

            $finishdate_one_connect = $data_sybmit['finishdate_one_connect'];
            $start_inp = date("Y-m-d");
            if(!empty($finishdate_one_connect)) {
                $finishdate = date('Y-m-d', strtotime($start_inp . " + $finishdate_one_connect days"));
            }
            else
            {
                $finishdate='';
            }
            // set post fields
            $post = [
                'username' => $data_sybmit['username'],
                'password' => $password,
                'multiuser' => $data_sybmit['multiuser'],
                'traffic' => $data_sybmit['traffic'],
                'type_traffic' => $data_sybmit['type_traffic'],
                'expdate' => $finishdate
            ];

            $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=adduser');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            if ($data_sybmit['type_traffic'] == "gb") {
                $traffic = $data_sybmit['traffic'] * 1024;
            } else {
                $traffic = $data_sybmit['traffic'];
            }
            if ($response['data']=='User Created')
            {
                $sql = "INSERT INTO `users` (`server`,`username`, `password`, `email`, `mobile`, `multiuser`, `startdate`, `finishdate`, `finishdate_one_connect`, `enable`, `traffic`, `info`,`customer_user`,`change_server`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array($queryCount[0]['id'],$data_sybmit['username'], $password, $data_sybmit['email'], $data_sybmit['mobile'], $data_sybmit['multiuser'], $data_sybmit['startdate'], $finishdate, $data_sybmit['finishdate_one_connect'], $data_sybmit['enable'], $traffic, $data_sybmit['info'], $Ukey, $data_sybmit['change_server']));
                if ($stmt) {
                    $sql = "INSERT INTO `Traffic` (`id`,`user`, `download`, `upload`, `total` ) VALUES (NULL,?,?,?,?)";
                    $stmt = $this->db->prepare($sql);
                    $use_traffic = $data_sybmit['username'];
                    $stmt->execute(array($use_traffic, '0', '0', '0'));
                    $stmt = $this->db->prepare("SELECT * FROM Traffic WHERE user=:user");
                    $stmt->execute(['user' => $use_traffic]);
                    $user = $stmt->rowCount();
                    if ($user == 0) {
                        $sql1 = "INSERT INTO `Traffic` (`user`, `download`, `upload`, `total` ) VALUES (?,?,?,?)";
                        $stmt1 = $this->db->prepare($sql1);
                        $stmt1->execute(array($use_traffic, '0', '0', '0'));
                    }
                    header("Location: users");
                    return true;
                } else {
                    return false;
                }
            }
            else {
                echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.$response['data'].'</div>
              </div>
            </div>';
            }
        } else {
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.confirm_re_user_lang.'</div>
              </div>
            </div>';
        }
    }
    public function submit_index_reseller($data_sybmit)
    {
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $username = $key_login[0];
            $Ukey = $key_login[0];
        }
        $query = $this->db->prepare("select * from users where customer_user='".$username."'");
        $query->execute();
        $queryCount = $query->rowCount();
        $queryCount=$queryCount+1;
        $query = $this->db->prepare("select * from package where id='".$data_sybmit['pack']."'");
        $query->execute();
        $query = $query->fetch();
        $account=$username.$queryCount;
        $chars = "abcdefghijklmnopqrstuvwxyz1234567890";
        $password = substr( str_shuffle( $chars ), 0, 6 );

        $query_u = $this->db->prepare("select * from users where username='".$account."'");
        $query_u->execute();
        $queryCount = $query_u->rowCount();
        if ($queryCount < 1) {
            $query_s = $this->db->prepare("select * from servers where id=" . $query['server']);
            $query_s->execute();
            $queryCount = $query_s->fetchAll(PDO::FETCH_ASSOC);

            $finishdate_one_connect = $query['day'];
            $start_inp = date("Y-m-d");
            if(!empty($finishdate_one_connect)) {
                $finishdate = date('Y-m-d', strtotime($start_inp . " + $finishdate_one_connect days"));
            }
            else
            {
                $finishdate='';
            }
            // set post fields
            $post = [
                'username' => $account,
                'password' => $password,
                'multiuser' => $query['multiuser'],
                'traffic' => $query['traffic'],
                'type_traffic' => 'gb',
                'expdate' => $finishdate
            ];

            $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=adduser');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);
            $traffic = $query['traffic'];
            if($query['multi']=='on') {
                $multiserver = 'true';
            }
            else
            {
                $multiserver = 'false';
            }
            $query_admin = $this->db->prepare("select * from admins where username_u='$Ukey'");
            $query_admin->execute();
            $query_admin = $query_admin->fetch();
            if($query_admin['credit_u']>=$query['amount'])
            {
            if ($response['data']=='User Created')
            {
                $sql = "INSERT INTO `users` (`server`,`username`, `password`, `email`, `mobile`, `multiuser`, `startdate`, `finishdate`, `finishdate_one_connect`, `enable`, `traffic`, `info`,`customer_user`,`change_server`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array($queryCount[0]['id'],$account, $password, $data_sybmit['email'], $data_sybmit['mobile'], $query['multiuser'], $start_inp, $finishdate, $query['day'], 'true', $traffic, $query['title'], $Ukey, $multiserver));
                if ($stmt) {
                    $sql = "INSERT INTO `Traffic` (`id`,`user`, `download`, `upload`, `total` ) VALUES (NULL,?,?,?,?)";
                    $stmt = $this->db->prepare($sql);
                    $use_traffic = $account;
                    $stmt->execute(array($use_traffic, '0', '0', '0'));
                    $stmt = $this->db->prepare("SELECT * FROM Traffic WHERE user=:user");
                    $stmt->execute(['user' => $use_traffic]);
                    $user = $stmt->rowCount();
                    if ($user == 0) {
                        $sql1 = "INSERT INTO `Traffic` (`user`, `download`, `upload`, `total` ) VALUES (?,?,?,?)";
                        $stmt1 = $this->db->prepare($sql1);
                        $stmt1->execute(array($use_traffic, '0', '0', '0'));
                    }

                    $sql_tras = "INSERT INTO `trans_reseller` (`desc_trans`, `amount_trans`, `date_time`, `username_trans`) VALUES (?,?,?,?)";
                    $stmt_tras = $this->db->prepare($sql_tras);
                    $credit_amount=$query['amount'];
                    $stmt_tras->execute(array('Create user '.$account, $credit_amount, date("Y-m-d"), $Ukey));
                    $price=$query_admin['credit_u']-$query['amount'];
                    $sql = "UPDATE admins SET credit_u=? WHERE username_u=?";
                    $this->db->prepare($sql)->execute([$price, $Ukey]);
                    header("Location: users");
                    return true;
                } else {
                    return false;
                }
            }
             else {
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.confirm_re_user_lang.'</div>
              </div>
            </div>';
        }
    }
            else {
echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.modal_credit_admin_wallet_lang.'</div>
              </div>
            </div>';
}
    }
        else {
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.confirm_re_user_lang.'</div>
              </div>
            </div>';
        }
        }

    public function delete_user($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $query = $this->db->prepare("select * from users where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $post = [
            'username' => $data_sybmit['username']
        ];

        $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=deleteuser');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        if ($response['data']=='User Deleted')
        {
        $this->db->prepare("DELETE FROM users WHERE username=?")->execute([$username]);
        $this->db->prepare("DELETE FROM Traffic WHERE user=?")->execute([$username]);
        header("Location: users");
            }

    }

    public function reset_traffic($data_sybmit)
    {
        $query = $this->db->prepare("select * from users where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $post = [
            'username' => $data_sybmit['username']
        ];

        $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=resetuser');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        if ($response['data']=='User Reset Traffic souccess') {
            $username = $data_sybmit['username'];
            $sql = "UPDATE Traffic SET upload=?,download=?,total=? WHERE user=?";
            $this->db->prepare($sql)->execute(['0', '0', '0', $username]);
            header("Location: users");
        }

    }

    public function renewal_update($data_sybmit)
    {
        $day_date=$data_sybmit['day_date'];
        $username=$data_sybmit['username'];
        $renewal_date=$data_sybmit['renewal_date'];
        $renewal_traffic=$data_sybmit['renewal_traffic'];
        $query = $this->db->prepare("select * from users where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = $this->db->prepare("select * from servers where id=" . $queryCount[0]['server']);
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        $post = [
            'username' => $username,
            'day_date' => $day_date,
            're_date' => $renewal_date,
            're_traffic' => $renewal_traffic
        ];

        $ch = curl_init($queryCount[0]['link'] . '/api&key=' . $queryCount[0]['token'] . '&method=renewal');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        if ($response['data']=='Renewal souccess') {
        $start_inp = date("Y-m-d");
        $end_inp = date('Y-m-d', strtotime($start_inp . " + $day_date days"));
            if ($renewal_date == 'yes') {
                $sql = "UPDATE users SET enable=?,startdate=?,finishdate=? WHERE username=?";
                $this->db->prepare($sql)->execute(['true',$start_inp, $end_inp, $username]);
            } else {
                $sql = "UPDATE users SET enable=?,finishdate=? WHERE username=?";
                $this->db->prepare($sql)->execute(['true',$end_inp, $username]);
            }

            if($renewal_traffic=='yes')
            {
                $sql = "UPDATE Traffic SET upload=?,download=?,total=? WHERE user=?";
                $this->db->prepare($sql)->execute(['0','0','0', $username]);
            }

        header("Location: users");
            }
    }


}

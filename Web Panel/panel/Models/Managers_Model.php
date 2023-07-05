<?php

class Managers_Model extends Model
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
            if ($queryCount == 0 && $queryCount_ress == 0) {
                header("location: login");
            }
        } else {
            header("location: login");
        }
    }

    public function managers()
    {
        $query = $this->db->prepare("select * from admins ORDER BY id DESC");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
    public function edit_manager($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $query = $this->db->prepare("select * from admins where username_u='$username'");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
    public function submit_ative($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $sql = "UPDATE admins SET condition_u=? WHERE username_u=?";
        $this->db->prepare($sql)->execute(['active', $username]);
        header("Location: managers");
    }
    public function submit_update($data_sybmit)
    {
        $password = $data_sybmit['password'];
        $credit = $data_sybmit['credit'];
        $username = $data_sybmit['username'];
        $data = [
            'password' => $password,
            'username' => $username,
            'credit' => $credit
        ];

        $query = $this->db->prepare("select * from admins where username_u='$username'");
        $query->execute();
        $queryCount = $query->fetch();
        if($credit>$queryCount['credit_u']) {
            $transaction_add_lang=transaction_add_lang;
            $sql_tras = "INSERT INTO `trans_reseller` (`desc_trans`, `amount_trans`, `date_time`, `username_trans`) VALUES (?,?,?,?)";
            $stmt_tras = $this->db->prepare($sql_tras);
            $credit_amount=$credit-$queryCount['credit_u'];
            $stmt_tras->execute(array($transaction_add_lang, $credit_amount, date("Y-m-d"), $username));
        }
        if($credit<$queryCount['credit_u']) {
            $transaction_remove_lang=transaction_remove_lang;
            $sql_tras = "INSERT INTO `trans_reseller` (`desc_trans`, `amount_trans`, `date_time`, `username_trans`) VALUES (?,?,?,?)";
            $stmt_tras = $this->db->prepare($sql_tras);
            $credit_amount=$queryCount['credit_u']-$credit;
            $stmt_tras->execute(array($transaction_remove_lang, $credit_amount, date("Y-m-d"), $username));
        }
        $sql = "UPDATE admins SET password_u=:password, credit_u=:credit WHERE username_u=:username ";

        $statement = $this->db->prepare($sql);
        $statement->execute($data);
        header("location: managers");
    }
    public function submit_deative($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $sql = "UPDATE admins SET condition_u=? WHERE username_u=?";
        $this->db->prepare($sql)->execute(['deactive', $username]);
        header("Location: managers");
    }
    public function submit_index($data_sybmit)
    {

        $query = $this->db->prepare("select * from admins where username='".$data_sybmit['username']."'");
        $query->execute();
        $queryCount = $query->rowCount();
        if ($queryCount < 1) {
            $sql = "INSERT INTO `admins` (`username_u`, `password_u`, `permission_u`, `credit_u`, `condition_u`) VALUES (?,?,?,?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($data_sybmit['username'], $data_sybmit['password'], 'agent', $data_sybmit['credit'], 'active'));
            if($data_sybmit['credit']>0) {
                $sql_tras = "INSERT INTO `trans_reseller` (`desc_trans`, `amount_trans`, `date_time`, `username_trans`) VALUES (?,?,?,?)";
                $stmt_tras = $this->db->prepare($sql_tras);
                $stmt_tras->execute(array(transaction_add_lang, $data_sybmit['credit'], date("Y-m-d"), $data_sybmit['username']));
            }
            if ($stmt) {
                header("Location: managers");
                return true;
            } else {
                return false;
            }
        } else {
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
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
        $query = $this->db->prepare("DELETE FROM admins WHERE username_u=?")->execute([$username]);
        if($query)
        {
            header("Location: managers");
        }
    }
}

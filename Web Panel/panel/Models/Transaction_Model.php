<?php

class Transaction_Model extends Model
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
            if ($queryCount >0) {
                define('permis','admin');
            }
            if ($query_ress >0) {
                define('permis','reseller');
            }
            $queryCount_ress = $query_ress->rowCount();
            if ($queryCount == 0 && $queryCount_ress == 0) {
                header("location: login");
            }
        } else {
            header("location: login");
        }
    }

    public function transaction()
    {
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where='';} else{$where=" where username_trans='$Ukey' ";}
        $query = $this->db->prepare("select * from trans_reseller $where ORDER BY id DESC");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
}

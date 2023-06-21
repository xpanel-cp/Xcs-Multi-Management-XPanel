<?php

class Index_Model extends Model
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
    //we will use the select function
    public function all_user()
    {
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where='';} else{$where=" where customer_user='$Ukey' ";}
        $query = $this->db->prepare("select * from users $where");
        $query->execute();
        $queryCount = $query->rowCount();
        return $queryCount;
    }
    public function traffic_user()
    {

        $query_traffic = $this->db->prepare("SELECT SUM(total) AS total FROM Traffic");
        $query_traffic->execute();
        $row = $query_traffic->fetch(PDO::FETCH_ASSOC);
        $queryCount_traffic = $row['total'];
        return $queryCount_traffic;
    }
    public function active_user()
    {
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where='';} else{$where=" and customer_user='$Ukey' ";}
        $query = $this->db->prepare("select * from users where enable='true' $where");
        $query->execute();
        $queryCount = $query->rowCount();
        return $queryCount;
    }
    public function deactive_user()
    {
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where='';} else{$where=" and customer_user='$Ukey' ";}
        $query = $this->db->prepare("select * from users where enable!='true' $where");
        $query->execute();
        $queryCount = $query->rowCount();
        return $queryCount;
    }

    public function user_band()
    {
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
        }
        if(permis=='admin'){$where='';} else{$where=" and users.customer_user='$Ukey' ";}
        $query = $this->db->prepare("select * from users,Traffic WHERE users.enable='true' AND users.username=Traffic.user AND Traffic.total!='0' $where ORDER BY Traffic.total DESC LIMIT 10");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }
}

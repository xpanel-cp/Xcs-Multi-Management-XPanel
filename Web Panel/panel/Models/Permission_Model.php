<?php

class Permission_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey = $key_login[0];
            $url = $_GET['url'];
            $url = explode('/', $url);
            $query = $this->db->prepare("select * from admins where username_u='" . $Ukey . "' and permission_u='agent' and login_key='" . $_COOKIE["xcskey"] . "'");
            $query->execute();
            $queryCount = $query->rowCount();
            if ($queryCount > 0) {
                if (ucfirst($url[0]) == 'Managers' || ucfirst($url[0]) == 'Settings' || ucfirst($url[0]) == 'online' || ucfirst($url[0]) == 'index' || ucfirst($url[0]) == 'checkip' || ucfirst($url[0]) == 'managers' || ucfirst($url[0]) == 'packages' || ucfirst($url[0]) == 'edituser' || ucfirst($url[0]) == 'editmanager' || ucfirst($url[0]) == 'editpackage') {
                    die('<h4 style="color: red">INACCESSIBILITY</h4>');
                }
            }
        }

    }
}
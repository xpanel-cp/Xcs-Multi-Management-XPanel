<?php

class Permission_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (isset($_COOKIE["xpkey"])) {
            $key_login = explode(':', $_COOKIE["xpkey"]);
            $Ukey = $key_login[0];
            $url = $_GET['url'];
            $url = explode('/', $url);
            $query = $this->db->prepare("select * from admins where username_u='" . $Ukey . "' and permission_u='admin' and login_key='" . $_COOKIE["xpkey"] . "'");
            $query->execute();
            $queryCount = $query->rowCount();
            if ($queryCount > 0) {
                if (ucfirst($url[0]) == 'Managers' || ucfirst($url[0]) == 'Settings' || ucfirst($url[0]) == 'online') {
                    die('<h4 style="color: red">INACCESSIBILITY</h4>');
                }
            }
        }

    }
}
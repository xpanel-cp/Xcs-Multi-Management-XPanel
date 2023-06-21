<?php

class Login_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function submit_index($data_sybmit)
	{
			$user = $data_sybmit['username'];
			$pass = $data_sybmit['password'];
            $query = $this->db->prepare("select * from setting where adminuser='".$user."' and adminpassword='".$pass."'");
            $query->execute();
            $queryCount = $query->rowCount();

            $query_ress = $this->db->prepare("select * from admins where username_u='".$user."' and password_u='".$pass."'");
            $query_ress->execute();
            $queryCount_ress = $query_ress->rowCount();
            if ($queryCount > 0) {
                $kay_login=$user.":XPlogin".time();
                $sql = "UPDATE setting SET login_key=? WHERE adminuser=?";
                $this->db->prepare($sql)->execute([$kay_login, $user]);
                setcookie("xpkey", $kay_login, time()+86400);
                header("location: index");
			}
			elseif ($queryCount_ress > 0) {
                $kay_login=$user.":XPlogin".time();
                $sql = "UPDATE admins SET login_key=? WHERE username_u=?";
                $this->db->prepare($sql)->execute([$kay_login, $user]);
                setcookie("xpkey", $kay_login, time()+86400);
                header("location: index");
			}
            else
            {
                header("location: login");
            }

	}
}

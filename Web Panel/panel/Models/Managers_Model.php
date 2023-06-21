<?php

class Managers_Model extends Model
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

    public function submit_ative($data_sybmit)
    {
        $username=$data_sybmit['username'];
        $sql = "UPDATE admins SET condition_u=? WHERE username_u=?";
        $this->db->prepare($sql)->execute(['active', $username]);
        header("Location: managers");
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
            $stmt->execute(array($data_sybmit['username'], $data_sybmit['password'], 'admin', '0', 'active'));
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
                  <img src="' . path . 'assets/images/xlogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">XPanel</strong>
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

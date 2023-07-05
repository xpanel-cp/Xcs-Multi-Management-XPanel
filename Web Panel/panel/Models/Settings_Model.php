<?php

class Settings_Model extends Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (isset($_COOKIE["xcskey"])) {
            $key_login = explode(':', $_COOKIE["xcskey"]);
            $Ukey = $key_login[0];
            $Pkey = $key_login[1];
            $query = $this->db->prepare("select * from setting where adminuser='" . $Ukey . "' and login_key='" . $_COOKIE["xcskey"] . "'");
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

    public function Get_settings()
    {
        $query = $this->db->prepare("select * from setting");
        $query->execute();
        $queryCount = $query->fetchAll();
        return $queryCount;
    }

    public function submit_pass($data_sybmit)
    {
        $sql = "UPDATE setting SET adminpassword=? WHERE id=?";
        $this->db->prepare($sql)->execute([$data_sybmit['password'], '1']);
        file_put_contents("/var/www/html/cp/Config/database.php", str_replace("\$password = \"" . $data_sybmit['password_old'] . "\"", "\$password = \"" . $data_sybmit['password'] . "\"", file_get_contents("/var/www/html/cp/Config/database.php")));
        $restpass = $this->db->prepare("SET PASSWORD FOR '" . $data_sybmit['username_r'] . "'@'localhost' = PASSWORD('" . $data_sybmit['password'] . "');");
        $restpass->execute();
        $fixpass = $this->db->prepare("GRANT ALL ON *.* TO '" . $data_sybmit['username_r'] . "'@'localhost'");
        $fixpass->execute();
        header("Location: Settings&sort=chengepass&pos=success");
    }

    public function index_api()
    {
        $query = $this->db->prepare("select * from ApiToken");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }

    public function index_server()
    {
        $query = $this->db->prepare("select * from servers");
        $query->execute();
        $queryCount = $query->fetchAll(PDO::FETCH_ASSOC);
        return $queryCount;
    }

    public function submit_server($data_sybmit)
    {
        $headers = @get_headers($data_sybmit['link']);
        if($headers && strpos( $headers[6], '200') or strpos( $headers[0], '200')) {
            $status = "200";
        }
        else {
            $status = "0";
        }

        if($status==200) {
            $sql1 = "INSERT INTO `servers` (`link`, `token`, `name`, `port_connection`,`port_connection_tls`) VALUES (?,?,?,?,?)";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->execute(array($data_sybmit['link'], $data_sybmit['token'], $data_sybmit['name'], $data_sybmit['port'], $data_sybmit['port_tls']));
            header("Location: Settings&sort=multiserver");
        }
        else{
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">' . confirm_link_lang . '</div>
              </div>
            </div>';
        }
    }
    public function delete_server($data)
    {
        $query = $this->db->prepare("select * from users where server='".$data."' and enable='true'");
        $query->execute();
        $queryCount = $query->rowCount();
        if ($queryCount < 1) {
            $this->db->prepare("DELETE FROM servers WHERE id=?")->execute([$data]);
            header("Location: Settings&sort=multiserver");
        }
        else
        {
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.setting_multiserver_delete_lang.'</div>
              </div>
            </div>';
        }
    }
    public function submit_api($data_sybmit)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $token = substr(str_shuffle($chars), 0, 15);
        $sql1 = "INSERT INTO `ApiToken` (`Token`, `Description`, `enable` ) VALUES (?,?,?)";
        $stmt1 = $this->db->prepare($sql1);
        $stmt1->execute(array(time() . $token, $data_sybmit['desc'], 'true'));
        header("Location: Settings&sort=api");
    }

    public function renew_api($data)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $token = substr(str_shuffle($chars), 0, 15);
        $sql = "UPDATE ApiToken SET Token=? WHERE Token=?";
        $this->db->prepare($sql)->execute([time() . $token, $data]);
        header("Location: Settings&sort=api");
    }

    public function delete_api($data)
    {
        $this->db->prepare("DELETE FROM ApiToken WHERE Token=?")->execute([$data]);
        header("Location: Settings&sort=api");
    }

    public function submit_restor_backup($data_sybmit)
    {
        echo $data_sybmit['name'];
        if (strpos($data_sybmit['name'], ".sql") !== false) {
            shell_exec("mysql -u '" . DB_USER . "' --password='" . DB_PASS . "' Xcs < /var/www/html/panel/storage/backup/" . $data_sybmit['name']);
            echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xcslogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
                  <strong class="me-auto">Xcs</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">' . confirm_success_lang . '</div>
              </div>
            </div>';
        }
    }

}

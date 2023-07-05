<?php
include_once("Models/Settings_Model.php");

class Settings extends Controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new Settings_Model();
        $settings=$this->model->Get_settings();
        $api_index=$this->model->index_api();
        $server_index=$this->model->index_server();
        //echo "<br>Page Index ";
        $data = array(
            "for" => $settings,
            "api" => $api_index,
            "server" => $server_index
        );
        if(isset($_GET['pos']))
        {
            $pos= htmlentities($_GET['pos']);
            if($pos=='success')
            {
                header("Location: Settings&sort=chengepass");
            }
        }
        if(isset($_GET['sort']))
        {
            $sort = htmlentities($_GET['sort']);
            define("sort", $sort);
        }
        else {
            define("sort", 'chengepass');
        }
        if(isset($_GET['delete-backup']))
        {
            $delete_backup= htmlentities($_GET['delete-backup']);
            if(file_exists("storage/backup/".$delete_backup))
            {
                unlink("storage/backup/".$delete_backup);
            }
        }

        $this->update_settings();
        $this->view->Render("Settings/index",$data);
    }

    function update_settings()
    {

        if (isset($_POST['changepass'])) {
            $username = htmlentities($_POST['user_root']);
            $password = htmlentities($_POST['changhe_pass_root']);
            $password_old = htmlentities($_POST['changhe_pass_root_old']);
            $data_sybmit = array(
                'username_r' => $username,
                'password' => $password,
                'password_old' => $password_old
            );
            $this->model->submit_pass($data_sybmit);
        }
        if (isset($_POST['addserver'])) {
            $link = htmlentities($_POST['link']);
            $token = htmlentities($_POST['token']);
            $name = htmlentities($_POST['name']);
            $port = htmlentities($_POST['port']);
            $port_tls = htmlentities($_POST['port_tls']);
            $data_sybmit = array(
                'link' => $link,
                'token' => $token,
                'name' => $name,
                'port' => $port,
                'port_tls' => $port_tls
            );
            $this->model->submit_server($data_sybmit);
        }
        if (isset($_GET['sort']) and $_GET['sort']=='multiserver' and !empty($_GET['delete'])) {
            $id = htmlentities($_GET['delete']);
            $this->model->delete_server($id);
        }
        if (isset($_POST['addapi'])) {
            $desc = htmlentities($_POST['desc']);
            $data_sybmit = array(
                'desc' => $desc
            );
            $this->model->submit_api($data_sybmit);
        }

        if (isset($_GET['sort']) and $_GET['sort']=='api' and !empty($_GET['delete'])) {
            $token = htmlentities($_GET['delete']);
            $this->model->delete_api($token);
        }
        if (isset($_GET['sort']) and $_GET['sort']=='api' and !empty($_GET['renew'])) {
            $renew = htmlentities($_GET['renew']);
            $this->model->renew_api($renew);
        }
        if (isset($_POST['savebackup'])) {
            $date = date("Y-m-d---h-i-s");
            shell_exec("mysqldump -u '".DB_USER."' --password='".DB_PASS."' Xcs > /var/www/html/panel/storage/backup/Xcs-".$date.".sql");
        }

        if (isset($_POST['upbackup'])) {

            $target_file = "storage/backup/" . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($imageFileType != "sql") {

                echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xlogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">XPanel</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.confirm_sql_lang.'</div>
              </div>
            </div>';

            }
            else
            {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xlogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">XPanel</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">'.confirm_success_lang.'</div>
              </div>
            </div>';
            }
        }

        if (isset($_GET['run'])) {
            $run_backup = htmlentities($_GET['run']);
            $data_sybmit = array(
                'name' => $run_backup
            );
            $this->model->submit_restor_backup($data_sybmit);
        }


    }
}

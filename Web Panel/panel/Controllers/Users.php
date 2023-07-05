<?php
include_once("Models/Users_Model.php");
class Users extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Users_Model();
        $this->index();
    }
    public function index()
    {
        $users=$this->model->users();
        $setting=$this->model->Get_settings();
        $server_index=$this->model->index_server();
        $server_package=$this->model->index_package();
        $Get_permis=$this->model->Get_permis();
        //  echo "<pre>";
        // print_r($users);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $password = substr( str_shuffle( $chars ), 0, 8 );
        $data = array(
            "for" => $users,
            "setting" => $setting,
            "password" => $password,
            "server" => $server_index,
            "package" => $server_package
        );
        if(isset($_GET['active'])) {
            if (!empty($_GET["active"])) {
                $usernme = htmlentities($_GET['active']);
                $data_sybmit = array(
                    'username' => $usernme
                );
                $this->model->submit_ative($data_sybmit);
            }
        }

        if(isset($_GET['deactive'])) {
            if (!empty($_GET["deactive"])) {
                $usernme = htmlentities($_GET['deactive']);
                $data_sybmit = array(
                    'username' => $usernme
                );
                $this->model->submit_deative($data_sybmit);
            }
        }

        if(isset($_GET['delete']) and $Get_permis=='admin')
        {
            $usernme = htmlentities($_GET['delete']);
            $data_sybmit = array(
                'username' =>$usernme
            );
            $this->model->delete_user($data_sybmit);
        }

        if(isset($_GET['reset-traffic']) and $Get_permis=='admin')
        {
            $usernme = htmlentities($_GET['reset-traffic']);
            $data_sybmit = array(
                'username' =>$usernme
            );
            $this->model->reset_traffic($data_sybmit);
        }

        $this->submit_index();
        $this->bulk_delete();
        $this->renewal_date();
        $this->change_server();
        $this->view->Render("Users/index",$data);
    }
    function change_server(){
        $Get_permis=$this->model->Get_permis();
        if (isset($_POST['change_server']) and $Get_permis=='admin') {
            $username = htmlentities($_POST['username_re']);
            $server = htmlentities($_POST['server']);

            $data_sybmit = array(
                'username' => $username,
                'server' => $server
            );
            $this->model->change_server($data_sybmit);

        }
    }
    function bulk_delete(){
        $Get_permis=$this->model->Get_permis();
        if (isset($_POST['delete']) and $Get_permis=='admin') {
            $checkbox = $_POST['usernamed'];
            foreach ($checkbox as $val) {
                $data_sybmit = array(
                    'username' => $val
                );
                //shell_exec("bash adduser " . $username . " " . $password);
                $this->model->delete_user($data_sybmit);
            }
        }
    }
    function renewal_date(){
        $Get_permis=$this->model->Get_permis();
        if (isset($_POST['renewal_date']) and $Get_permis=='admin') {
            $username_re = htmlentities($_POST['username_re']);
            $day_date = htmlentities($_POST['day_date']);

            $renewal_date = htmlentities($_POST['re_date']);
            $renewal_traffic = htmlentities($_POST['re_traffic']);

            $data_sybmit = array(
                'username' => $username_re,
                'day_date' => $day_date,
                'renewal_date' => $renewal_date,
                'renewal_traffic' => $renewal_traffic
            );

            //shell_exec("bash adduser " . $username . " " . $password);
            $this->model->renewal_update($data_sybmit);
        }

    }
    function submit_index(){
        $Get_permis=$this->model->Get_permis();
        if (isset($_POST['submit']) and $Get_permis=='admin')
        {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);
            $email = htmlentities($_POST['email']);
            $mobile = htmlentities($_POST['mobile']);
            $multiuser = htmlentities($_POST['multiuser']);
            $connection_start = htmlentities($_POST['connection_start']);
            $traffic = htmlentities($_POST['traffic']);
            $type_traffic = htmlentities($_POST['type_traffic']);
            $expdate = htmlentities($_POST['expdate']);
            $desc = htmlentities($_POST['desc']);
            $server = htmlentities($_POST['server']);
            $change_server = htmlentities($_POST['change_server']);
            $st_date=date("Y-m-d");
            $data_sybmit = array(
                'username' =>$username,
                'password' => $password,
                'email' => $email,
                'mobile' => $mobile,
                'multiuser' => $multiuser,
                'startdate' => $st_date,
                'finishdate' => $expdate,
                'finishdate_one_connect' => $connection_start,
                'enable' => 'true',
                'traffic' => $traffic,
                'type_traffic' => $type_traffic,
                'referral' => '',
                'info' => $desc,
                'id_server' => $server,
                'change_server' => $change_server
            );
            $this->model->submit_index($data_sybmit);
        }

        if (isset($_POST['submit']) and $Get_permis!='admin')
        {
            $email = htmlentities($_POST['email']);
            $mobile = htmlentities($_POST['mobile']);
            $pack = htmlentities($_POST['pack']);
            $data_sybmit = array(
                'email' => $email,
                'mobile' => $mobile,
                'pack' => $pack
            );
            $this->model->submit_index_reseller($data_sybmit);
        }

    }

}

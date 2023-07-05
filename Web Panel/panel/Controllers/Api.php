<?php
include_once("Models/Api_Model.php");
class Api extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Api_Model();
        $key = htmlentities($_GET['key']);
        $token = $this->model->check_token($key);
        if($token == 'allowed'){
            $this->index();
        }else{

            echo 'invalid api key';

        }

    }
    public function index()
    {
        //list user
        if(isset($_GET['method']) && $_GET['method'] == "listuser"){
            $list_users = $this->model->list_user();
            foreach ($list_users as $list_user) {

                $total = $list_user['total'] . ' GB';
                $server = $_SERVER["SERVER_NAME"];
                if (empty($list_user['port_connection_tls']) || $list_user['port_connection_tls'] == 'NULL') {
                    $ssh_tls_port = '444';
                } else {
                    $ssh_tls_port = $list_user['port_connection_tls'];
                }
                $data [] = array(
                    'id' => $list_user['id'],
                    'server_name' => $list_user['name'],
                    'server' => $server,
                    'username' => $list_user['username'],
                    'password' => $list_user['password'],
                    'ssh_port' => $list_user['port_connection'],
                    'ssh_tls_port' => $ssh_tls_port,
                    'email' => $list_user['email'],
                    'mobile' => $list_user['mobile'],
                    'multiuser' => $list_user['multiuser'],
                    'startdate' => $list_user['startdate'],
                    'finishdate' => $list_user['finishdate'],
                    'finishdate_one_connect' => $list_user['connection_start'],
                    'customer_user' => $list_user['customer_user'],
                    'enable' => $list_user['enable'],
                    'traffic' => $list_user['traffic'],
                    'referral' => $list_user['referral'],
                    'info' => $list_user['info'],
                    'traffic_usage' => $total,
                    'qr_ssh' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://" . $list_user['username'] . ":" . $list_user['password'] . "@" . $server . ":" . $list_user['port_connection'] . "/#" . $list_user['username'],
                    'qr_ssh_tls' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://" . $list_user['username'] . ":" . $list_user['password'] . "@" . $server . ":" . $ssh_tls_port . "/#" . $list_user['username']
                );
            }
            $this->response($data) ;
        }

        //sort status user
        if(isset($_GET['method']) && $_GET['method'] == "users" && !empty($_GET['status'])){
            $status_user = $this->model->status_user($_GET['status']);
            foreach ($status_user as $list_user) {

                $total = $list_user['total'] . ' GB';
                $server = $_SERVER["SERVER_NAME"];
                if (empty($list_user['port_connection_tls']) || $list_user['port_connection_tls'] == 'NULL') {
                    $ssh_tls_port = '444';
                } else {
                    $ssh_tls_port = $list_user['port_connection_tls'];
                }
                $data [] = array(
                    'id' => $list_user['id'],
                    'server_name' => $list_user['name'],
                    'server' => $server,
                    'username' => $list_user['username'],
                    'password' => $list_user['password'],
                    'ssh_port' => $list_user['port_connection'],
                    'ssh_tls_port' => $ssh_tls_port,
                    'email' => $list_user['email'],
                    'mobile' => $list_user['mobile'],
                    'multiuser' => $list_user['multiuser'],
                    'startdate' => $list_user['startdate'],
                    'finishdate' => $list_user['finishdate'],
                    'finishdate_one_connect' => $list_user['connection_start'],
                    'customer_user' => $list_user['customer_user'],
                    'enable' => $list_user['enable'],
                    'traffic' => $list_user['traffic'],
                    'referral' => $list_user['referral'],
                    'info' => $list_user['info'],
                    'traffic_usage' => $total,
                    'qr_ssh' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://" . $list_user['username'] . ":" . $list_user['password'] . "@" . $server . ":" . $list_user['port_connection'] . "/#" . $list_user['username'],
                    'qr_ssh_tls' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://" . $list_user['username'] . ":" . $list_user['password'] . "@" . $server . ":" . $ssh_tls_port . "/#" . $list_user['username']
                );
            }

            $this->response($data) ;
        }

        //show user
        if(isset($_GET['method']) && $_GET['method'] == "user" && !empty($_GET['username'])){
            $usernme = htmlentities($_GET['username']);
            $show_user = $this->model->show_user($usernme);
            $list_user=$show_user[0];

                $total = $list_user['total'] . ' GB';
                $server = $_SERVER["SERVER_NAME"];
                if (empty($list_user['port_connection_tls']) || $list_user['port_connection_tls'] == 'NULL') {
                    $ssh_tls_port = '444';
                } else {
                    $ssh_tls_port = $list_user['port_connection_tls'];
                }
                $data [] = array(
                    'id' => $list_user['id'],
                    'server_name' => $list_user['name'],
                    'server' => $server,
                    'username' => $list_user['username'],
                    'password' => $list_user['password'],
                    'ssh_port' => $list_user['port_connection'],
                    'ssh_tls_port' => $ssh_tls_port,
                    'email' => $list_user['email'],
                    'mobile' => $list_user['mobile'],
                    'multiuser' => $list_user['multiuser'],
                    'startdate' => $list_user['startdate'],
                    'finishdate' => $list_user['finishdate'],
                    'finishdate_one_connect' => $list_user['connection_start'],
                    'customer_user' => $list_user['customer_user'],
                    'enable' => $list_user['enable'],
                    'traffic' => $list_user['traffic'],
                    'referral' => $list_user['referral'],
                    'info' => $list_user['info'],
                    'traffic_usage' => $total,
                    'qr_ssh' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://" . $list_user['username'] . ":" . $list_user['password'] . "@" . $server . ":" . $list_user['port_connection'] . "/#" . $list_user['username'],
                    'qr_ssh_tls' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://" . $list_user['username'] . ":" . $list_user['password'] . "@" . $server . ":" . $ssh_tls_port . "/#" . $list_user['username']
                );
            $this->response($data) ;
        }



    }

    function response($data){

        $res= [
            'status' => 200,
            'data'   => $data

        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($res,  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

}

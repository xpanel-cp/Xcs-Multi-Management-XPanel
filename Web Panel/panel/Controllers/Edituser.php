<?php
include_once("Models/Edituser_Model.php");
class Edituser extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Edituser_Model();
        $this->index();
    }

    public function index()
    {
        if(isset($_GET['username'])) {
            if (!empty($_GET["username"])) {
                $usernme = htmlentities($_GET['username']);
                $data_sybmit = array(
                    'username' => $usernme
                );
                $user=$this->model->user($data_sybmit);
                $data = array(
                    "for" => $user
                );
                if (isset($_POST['submit'])) {
                    $username = htmlentities($_POST['username']);
                    $password = htmlentities($_POST['password']);
                    $email = htmlentities($_POST['email']);
                    $mobile = htmlentities($_POST['mobile']);
                    $multiuser = htmlentities($_POST['multiuser']);
                    $traffic = htmlentities($_POST['traffic']);
                    $type_traffic = htmlentities($_POST['type_traffic']);
                    $expdate = htmlentities($_POST['expdate']);
                    $desc = htmlentities($_POST['desc']);
                    $activate = htmlentities($_POST['activate']);
                    if ($type_traffic == "gb") {
                        $traffic = $traffic * 1024;
                    } else {
                        $traffic = $traffic;
                    }
                    $data_sybmit = array(
                        'username' => $username,
                        'password' => $password,
                        'email' => $email,
                        'mobile' => $mobile,
                        'multiuser' => $multiuser,
                        'finishdate' => $expdate,
                        'traffic' => $traffic,
                        'info' => $desc,
                        'activate' => $activate
                    );
                    $this->model->submit_update($data_sybmit);
                }
                $this->view->Render("Users/edituser",$data);
            }
            else{header("Location: /cp/users");}
        }


    }
}
<?php
include_once("Models/Managers_Model.php");
class Managers extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Managers_Model();
        $this->index();
    }
    public function index()
    {
        $users=$this->model->managers();
        //  echo "<pre>";
        // print_r($users);
        $data = array(
            "for" => $users
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

        if(isset($_GET['delete']))
        {
            $usernme = htmlentities($_GET['delete']);
            $data_sybmit = array(
                'username' =>$usernme
            );
            $this->model->delete_user($data_sybmit);
        }


        $this->submit_index();

        $this->view->Render("Managers/index",$data);
    }
    function submit_index(){

        if (isset($_POST['submit']))
        {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);

            $data_sybmit = array(
                'username' =>$username,
                'password' => $password
            );
            //shell_exec("bash adduser " . $username . " " . $password);
            $this->model->submit_index($data_sybmit);
            //header('location: users');


        }

    }




}

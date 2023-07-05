<?php
include_once("Models/Managers_Model.php");
class Editmanager extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Managers_Model();
        $this->edit_manager();
    }

    public function edit_manager()
    {
        if(isset($_GET['username'])) {
            if (!empty($_GET["username"])) {
                $usernme = htmlentities($_GET['username']);
                $data = array(
                    'username' => $usernme
                );
                $user=$this->model->edit_manager($data);

                if (isset($_POST['submit'])) {
                    $username = htmlentities($_POST['username']);
                    $password = htmlentities($_POST['password']);
                    $credit = htmlentities($_POST['credit']);

                    $data_sybmit = array(
                        'username' => $username,
                        'password' => $password,
                        'credit' => $credit
                    );
                    $this->model->submit_update($data_sybmit);
                }
                $data = array(
                    "for" => $user
                );
                $this->view->Render("Managers/edit",$data);
            }
            else{header("Location: /managers");}
        }


    }
}
    ?>
<?php
include_once("Models/Packages_Model.php");
class Packages extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Packages_Model();
        $this->index();
        $this->edit_manager();
    }
    public function index()
    {
        $pack=$this->model->index();
        $server_index=$this->model->index_server();
        //  echo "<pre>";
        // print_r($users);
        $data = array(
            "for" => $pack,
            "server" => $server_index
        );

        if(isset($_GET['delete']))
        {
            $id = htmlentities($_GET['delete']);
            $data_sybmit = array(
                'id' =>$id
            );
            $this->model->delete_pack($data_sybmit);
        }


        $this->submit_index();

        $this->view->Render("Packages/index",$data);
    }
    function submit_index(){

        if (isset($_POST['submit']))
        {
            $title = htmlentities($_POST['title']);
            $amount= htmlentities($_POST['amount']);
            $day = htmlentities($_POST['day']);
            $multi = htmlentities($_POST['multi']);
            $server = htmlentities($_POST['server']);
            $traffic = htmlentities($_POST['traffic']);
            $multiuser = htmlentities($_POST['multiuser']);

            $data_sybmit = array(
                'title' =>$title,
                'amount' => $amount,
                'day' => $day,
                'multi' => $multi,
                'server' => $server,
                'traffic' => $traffic,
                'multiuser' => $multiuser
            );
            //shell_exec("bash adduser " . $username . " " . $password);
            $this->model->submit_index($data_sybmit);
            //header('location: users');


        }

    }
}
?>
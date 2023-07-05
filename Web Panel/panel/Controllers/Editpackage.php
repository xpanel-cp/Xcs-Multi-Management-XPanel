<?php
include_once("Models/Packages_Model.php");
class Editpackage extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Packages_Model();
        $this->index();
    }

    public function index()
    {
        if (isset($_GET['id'])) {
            if (!empty($_GET["id"])) {
                $id = htmlentities($_GET['id']);
                $server_index=$this->model->index_server();

                $data = array(
                    'id' => $id
                );
                $user = $this->model->edit_package($data);

                if (isset($_POST['submit'])) {
                    $id = htmlentities($_POST['id']);
                    $title = htmlentities($_POST['title']);
                    $amount= htmlentities($_POST['amount']);
                    $day = htmlentities($_POST['day']);
                    $multi = htmlentities($_POST['multi']);
                    $server = htmlentities($_POST['server']);
                    $traffic = htmlentities($_POST['traffic']);
                    $multiuser = htmlentities($_POST['multiuser']);

                    $data_sybmit = array(
                        'id' =>$id,
                        'title' =>$title,
                        'amount' => $amount,
                        'day' => $day,
                        'multi' => $multi,
                        'server' => $server,
                        'traffic' => $traffic,
                        'multiuser' => $multiuser
                    );
                    $this->model->submit_update($data_sybmit);
                }
                $data = array(
                    "for" => $user,
                    "server" => $server_index
                );
                $this->view->Render("Packages/edit", $data);
            } else {
                header("Location: /packages");
            }
        }
    }
}
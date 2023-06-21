<?php
include_once("Models/Index_Model.php");

class Online extends Controller
{

    function __construct()
    {

        parent::__construct();
        $this->model = new Index_Model();

        if(isset($_GET['kill-id'])) {
            if (!empty($_GET["kill-id"])) {
                $killid = htmlentities($_GET['kill-id']);
                shell_exec("sudo kill -9 " . $killid);
            }
        }
        if(isset($_GET['kill-user'])) {
            if (!empty($_GET["kill-user"])) {
                $killuser = htmlentities($_GET['kill-user']);
                shell_exec("sudo killall -u " . $killuser);
            }
        }
        $this->view->Render("Online/index");
    }
}

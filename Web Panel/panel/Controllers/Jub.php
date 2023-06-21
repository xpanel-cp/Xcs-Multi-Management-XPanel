<?php
require_once("Models/Jub_Model.php");
class Jub extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Fixjubnet_Model();
        $this->index();
    }

    public function index()
    {
        echo"kkk";
        if(isset($_GET['cron'])) {
            if (!empty($_GET["cron"]) and $_GET["cron"]=='expire') {
                $this->model->cronexpire();
            }
        }
    }

}
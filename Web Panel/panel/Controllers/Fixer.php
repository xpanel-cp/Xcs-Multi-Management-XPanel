<?php
include_once("Models/Fixer_Model.php");
class Fixer extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Fixer_Model();
        $this->index();
    }
    public function index()
    {
        if (isset($_GET['jub'])) {
            if (!empty($_GET["jub"]) and $_GET["jub"] == 'exp') {
                $this->model->cronexp();
            }
            if (!empty($_GET["jub"]) and $_GET["jub"] == 'synstraffic') {
                $this->model->synstraffic();
            }

            if (!empty($_GET["jub"]) and $_GET["jub"] == 'multi') {
                $this->model->multiuser();
            }
        }

    }
}

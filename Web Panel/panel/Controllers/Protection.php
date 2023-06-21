<?php
include_once("Models/Index_Model.php");

class Protection extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Index_Model();

        $this->index();

    }
    public function index()
    {
        $this->view->Render("protection");

    }
}
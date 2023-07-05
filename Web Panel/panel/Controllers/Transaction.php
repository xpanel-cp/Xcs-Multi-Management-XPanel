<?php
include_once("Models/Transaction_Model.php");
class Transaction extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Transaction_Model();
        $this->index();
    }
    public function index()
    {
        $trans=$this->model->transaction();
         //echo "<pre>";
         //print_r($trans);
        $data = array(
            "for" => $trans
        );


        $this->view->Render("Transaction/index",$data);
    }

}

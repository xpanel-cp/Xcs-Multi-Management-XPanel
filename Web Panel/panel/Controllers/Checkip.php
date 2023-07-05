<?php
include_once("Models/Settings_Model.php");

class Checkip extends Controller
{
	function __construct()
	{
		parent::__construct();
        $this->model = new Settings_Model();
        $server_index=$this->model->index_server();
        $data = array(
            "server" => $server_index
        );
        $this->view->Render("Checkip/index",$data);
	}
}

<?php
include_once("Models/Reinstall_Model.php");

class Reinstall extends Controller
{
	function __construct()
	{
		parent::__construct();
        $this->model = new Reinstall_Model();
        $this->model->install();
	}


}

<?php
include_once("Models/Index_Model.php");

class Checkip extends Controller
{
	function __construct()
	{
		parent::__construct();
        $this->model = new Index_Model();

        $this->view->Render("Checkip/index");
	}
}

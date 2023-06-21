<?php

class Documents extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->index();
    }

    public function index()
    {
        if (isset($_GET['logout'])) {
            setcookie("xpkey", "", time() - 86400);
            header("location: login");
        }
        $this->view->render("Document/index");

    }
}

<?php

class View
{
    function __construct()
    {
        //echo "<br>we are in page View";
        $this->result = "OK";
    }

    function Render($name, $data = null)
    {
        $name = ucfirst($name);
        if ($name != 'Login/index') {
            require_once("Views/Header.php");
            require_once("Views/" . $name . ".php");
            require_once("Views/Footer.php");
        } else {
            require_once("Views/" . $name . ".php");
        }
    }

}

<?php
$protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
$http_host=$_SERVER['HTTP_HOST'];
define('path', $protocol.'://'.$http_host.'/');
$fakeurl = "https://google.com";
define('fakeurl', $fakeurl);

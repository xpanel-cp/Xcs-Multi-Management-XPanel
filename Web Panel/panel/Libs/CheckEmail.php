<?php
	
	if(!isset($_POST["Email"]))
	{
		echo "value is empty";
		return;
	}
	
	$Email = $_POST["Email"];
	$chrList_Email = '/\A([^@\s]+)@(([a-z0-9]+\.)+[a-z]{2,})\Z/i';
	
	if(preg_match($chrList_Email, $Email) == false)
	{
		echo json_encode("Invalid");
	}
	else
	{
		echo json_encode("valid");
	}
	
?>
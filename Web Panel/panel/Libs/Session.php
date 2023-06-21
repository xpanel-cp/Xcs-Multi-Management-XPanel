<?php

	class Session
	{
		public static function init()
		{
			@session_start();
		}
		
		public static function IsLogin()
		{	
			Session::init();
			if(isset($_SESSION["Login"]))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public static function LoginDo($key, $value, $username)
		{
			Session::init();
			$_SESSION[$key] = $value;
			
			$_SESSION["Uname"] = $username;
		}
		
		public static function GetUserLogin()
		{
			return $_SESSION["Uname"];
		}
		
		public static function Logout()
		{
			session_destroy();
			header("location: ../Index");
		}		
	}
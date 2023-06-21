<?php

class Database extends PDO
{
	function __construct()
	{
        $db_type=DB_TYPE;
		parent::__construct(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	}
}


<?php

class Reinstall_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function install()
    {
        $statements = [
            'CREATE TABLE setting(
	        id   INT AUTO_INCREMENT,
	        adminuser  VARCHAR(100) NOT NULL,
	        adminpassword VARCHAR(100) NULL,
			language   VARCHAR(100) NULL,
			login_key   VARCHAR(100) NULL,
	        PRIMARY KEY(id)
	    );',
            'CREATE TABLE users(
						id   INT AUTO_INCREMENT,
						server  VARCHAR(100) NOT NULL,
						username  VARCHAR(100) NOT NULL,
						password VARCHAR(50) NULL,
						email   VARCHAR(100) NULL,
						mobile   VARCHAR(100) NULL,
						multiuser   VARCHAR(100) NULL,
						startdate   VARCHAR(100) NULL,
						finishdate   VARCHAR(100) NULL,
						finishdate_one_connect   VARCHAR(100) NULL,
						enable   VARCHAR(100) NULL,
						traffic   VARCHAR(100) NULL,
						info   VARCHAR(100) NULL,
						customer_user   VARCHAR(100) NULL,
						PRIMARY KEY(id)
				);',
            'CREATE TABLE servers(
							id  INT AUTO_INCREMENT,
							link  VARCHAR(100) NOT NULL,
							token VARCHAR(100) NULL,
							name   VARCHAR(100) NULL,
							PRIMARY KEY(id)
					);',
            'CREATE TABLE ApiToken(
								id  INT AUTO_INCREMENT,
								Token  VARCHAR(100) NOT NULL,
								Description VARCHAR(100) NULL,
								enable   VARCHAR(100) NULL,
								PRIMARY KEY(id)
						);',
            'CREATE TABLE admins(
								id  INT AUTO_INCREMENT,
								username_u VARCHAR(100) NOT NULL,
								password_u VARCHAR(100) NULL,
								permission_u VARCHAR(100) NULL,
								credit_u VARCHAR(250) NULL,
								condition_u VARCHAR(100) NULL,
								login_key VARCHAR(100) NULL,
								PRIMARY KEY(id)
						);',
            'CREATE TABLE package(
								id  INT AUTO_INCREMENT,
								title VARCHAR(100) NOT NULL,
								amount VARCHAR(100) NULL,
								day VARCHAR(100) NULL,
								PRIMARY KEY(id)
						);',
            'CREATE TABLE transaction (
								id  INT AUTO_INCREMENT,
								desc VARCHAR(100) NOT NULL,
								amount VARCHAR(100) NULL,
								date_time VARCHAR(100) NULL,
								PRIMARY KEY(id)
						);',
            'CREATE TABLE Traffic(
									id  INT AUTO_INCREMENT,
									user  VARCHAR(100) NOT NULL,
									download VARCHAR(100) NULL,
									upload   VARCHAR(100) NULL,
									total   VARCHAR(100) NULL,
									CONSTRAINT reference_unique UNIQUE (user),
									PRIMARY KEY(id)
							)'];

        // execute SQL statements
        foreach ($statements as $statement) {
            $this->db->exec($statement);
        }
        $sql=$this->db->prepare("TRUNCATE TABLE `setting`");
        $sql->execute();
        $sql = "INSERT INTO `setting` (`id`,`adminuser`, `adminpassword`) VALUES (NULL,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(DB_USER, DB_PASS));

        echo "success";
    }
}

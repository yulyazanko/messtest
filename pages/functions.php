<?php 
	function connectPDO()
	{
		$host= 'localhost';
		$user= 'root';
		$pass= '';
		$dbname='messtest';
		// переменные для pdo
		$dsn='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
		$options=array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8');
		$pdo=new PDO($dsn, $user, $pass, $options);
		return $pdo;
	}
	
 ?>

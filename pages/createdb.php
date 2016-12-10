<?php 

	include_once('functions.php');

	$pdo=connectPDO();

	
	// создаем таблицы
	$t1='create table Users(id int not null auto_increment  primary key,
							user_id varchar(255) NOT NULL UNIQUE,
							name varchar(255),
							link varchar(255),
							path varchar(255)) default charset="utf8"';
	$t2='create table Messages (id int not null auto_increment primary key,
							message varchar(2048) not null,
							userid int,
							foreign key (userid) references Users(id),
							datemess datetime) default charset="utf8"';
	$t3='create table Comments1 (id int not null auto_increment primary key,
							comment1 varchar(2048) not null,
							messid int,
							foreign key (messid) references Messages(id),
							userid int,
							foreign key (userid) references Users(id),
							datecomm datetime) default charset="utf8"';
	$t4='create table Comments2 (id int not null auto_increment primary key,
							comment2 varchar(2048) not null,
							comm1id int,
							userid int,
							foreign key (userid) references Users(id),
							foreign key (comm1id) references Comments1(id),
							datecomm datetime) default charset="utf8"';
	

	
	$pdo->query($t1);
	$pdo->query($t2);
	$pdo->query($t3);
	$pdo->query($t4);


 ?>
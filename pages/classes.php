<?php 
	
	class User
	{
		protected $id; // id пол-ля в нашей БД
		protected $user_id; // id пол-ля полученный от facebook
		protected $name; // имя пол-ля
		protected $link; // ссылка на профиль пол-ля
		protected $path; //путь к картинке

		function __construct($user_id, $name, $link, $path, $id=0)
		{
			$this->id=$id;
			$this->user_id=$user_id;
			$this->name=$name;
			$this->link=$link;
			$this->path=$path;
		}
		
		function getId()
		{
			return $this->id;
		}

		function userIntoDB() //метод для занесения данных пол-ля в БД
		{
			$db=connectPDO();
			$ps=$db->prepare('insert into users(user_id, name, link, path) values(?,?,?,?)');
		    $ps->execute(array($this->user_id, $this->name, $this->link, $this->path));
		}

		static function userFromDB($user_id)// метод для получения данных пользователя из БД по фейсбук-id
		{
			$db=connectPDO();
			$res=$db->query('select * from Users where user_id='.$user_id);
			$row=$res->fetch();
			$user= new User($user_id, $row['name'], $row['link'], $row['path'], $row['id']);
			return $user;
		}
		static function userFromDB_id($id)// метод для получения данных пользователя по его id
		{
			$db=connectPDO();
			$res=$db->query('select * from Users where id='.$id);
			$row=$res->fetch();
			$user= new User($row['user_id'], $row['name'], $row['link'], $row['path'], $id);
			return $user;
		}
	
		function userInfo() // метод для вывода данных пользователя
		{
			echo'<p class="userInfo"><a href="'.$this->path.'" target="_blank"><img src="'.$this->path.'" alt="Изображение пользователя" class="userimg img-thumbnail"></a> <a href="'.$this->link.'" class=" badge" target="_blank" title="Кликните, чтобы перейти на профиль пользователя">'.$this->name.'</a></p>';

		}
		

	}

	class Message
	{
		protected $id; // id сообщения в БД
		protected $message;  // само сообщение
		protected $userid;  // id пол-ля в таблице USER
		protected $datemess; //дата сообщения

		function __construct($message, $userid, $datemess, $id=0)
		{
			$this->id=$id;
			$this->message=$message;
			$this->userid=$userid;
			$this->datemess=$datemess;
		}
		function geIid()
		{
			 return $this->id;
		}

		static function messIntoDB($mess, $user_id) //метод для добаления коментария пол-ля в бд 
		{
			$db=connectPDO();
			$res=$db->query('select id from Users where user_id='.$user_id);
			$row=$res->fetch();
			$ps=$db->prepare('insert into Messages(message, userid, datemess) values(?,?,?)');
			$ps->execute(array($mess, $row['id'] , @date('Y-m-d H:i:s')));
			echo '<script>window.location.replace("index.php?id=2")</script>';// предотвращаем повторную отправку формы
					
		}

		static function getMessList() //метод для получения из базы данных всех сообщений
		{	
			$list=array();
			$db=connectPDO();
		 	$res=$db->query('select * from Messages order by datemess DESC');
			while($row=$res->fetch())
		 	{
				$mess= new Message($row['message'], $row['userid'], $row['datemess'], $row['id']);
				$list[]=$mess;
		 	}
		 	return $list;
		 }
		 function drawMess() // метод вывода сообщения
		 {
		 	$i=0;
		 	$db=connectPDO();
		 	$res=$db->query('select user_id from Users where id='.$this->userid); // получаем фейсбук-id по id пол-ля, кот. оставил сообщ.
		 	$row=$res->fetch();
			$u=User::userFromDB($row['user_id']); // пол-ем пол-ля, кот. оставил данное сообщение
			$u_id=$u->getId();
			$res=$db->query('select * from Messages where userid='.$u_id);
			while($row=$res->fetch())
			{
				$i++;
			}
			
			$u->userInfo();  //выводим данные пол-ля, кот. оставил сообщение
			echo '<hr>';
			echo '<p>'.$this->message.'</p>'; //выводим сообщение
			echo '<p class="count">Сообщений пользователя <span class="badge">'.$i.'</span></p>';
			echo '<hr>';
			echo '<p class="datemess">'.$this->datemess.'</p>'; //выводим время сообщения
							
		 }
		 function addCom1()// поле для добавления комментария к сообщению и кнопку отпр. ком.(hidden, при нажатии на "добавить" появляется поле ввода и кнопка)
		 {		
			echo '<p class="addcom1"><span class="addcom1" id="addcom1_'.$this->id.'">Добавить комментарий<span></p>'; // id- id сообщения, к кот. относится ком-ий
			echo '<div id="com1_'.$this->id.'" class="block_com1">';
			echo '<div class="form-group">';
			echo '<textarea class="form-control" name="com1_'.$this->id.'" rows="4"></textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<input type="submit" name="addcom1'.$this->id.'" class="btn btn-success" value="Добавить комментарий">';
			echo '</div>';
			echo '</div>';
		 }
		 static function messFromDB($id) // получаем сообщение по его id
		 {
		 	$db=connectPDO();
			$res=$db->query('select * from Messages where id='.$id);
			$row=$res->fetch();
			$message= new Message($row['message'], $row['userid'], $row['datemess'], $row['id']);
			return $message;
		 }
		 function com1IntoDB($com1) // заносим в БД ком-ий к сообщению
		 {	
		 	$user=User::userFromDB($_SESSION['authuser']); 
		 	$u=$user->getId();
		 	$db=connectPDO();
			$ps=$db->prepare('insert into Comments1(comment1, messid, userid, datecomm) values(?,?,?,?)');
		    $ps->execute(array($com1, $this->id, $u ,@date('Y-m-d H:i:s')));
		    echo '<script>window.location.replace("index.php?id=2")</script>'; // предотвращаем повторную отправку формы
		 }
		 function getCom1() // метод для получения всех ком-риев к сообщению с данным id
		 {	
		 	$com1=array();
		 	$db=connectPDO();
		 	$res=$db->query('select * from Comments1 where messid='.$this->id);
		 	while($row=$res->fetch())
		 	{
		 		$com1[]=$row;
		 	}
		 	return $com1;
		 }
		 function drawCom1($userid, $com1, $date) // метод для вывода ком-ия по его id
		 {	
		  	$u=User::userFromDB_id($userid);
		 	$u->userInfo();
		 	echo '<hr>';
			echo '<p>'.$com1.'</p>'; //выводим сообщение
			echo '<hr>';
			echo '<p class="datemess">'.$date.'</p>'; //выводим время сообщения
			
		 }
		  function addCom2($id) // поле для добавления комментария к ком-ию по id ком-ия 
		 {	
			echo '<p class="addcom2"><span class="addcom2" id="addcom2_'.$id.'">Добавить комментарий к комментарию</span></p>'; // id- id ком-ия, к кот. относится ком-ий
			echo '<div id="com2_'.$id.'" class="block_com2">';
			echo '<div class="form-group">';
			echo '<textarea class="form-control" name="com2_'.$id.'" rows="4"></textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<input type="submit" name="addcom2'.$id.'" class="btn btn-success" value="Добавить комментарий к комментарию">';
			echo '</div>';
			echo '</div>';
		 }
		  
		  static function com2IntoDB($com2, $id) // заносим комментарий к комментарию в БД
		  {
		  	$user=User::userFromDB($_SESSION['authuser']); 
		 	$u=$user->getId();
		 	$db=connectPDO();
			$ps=$db->prepare('insert into Comments2(comment2, comm1id, userid, datecomm) values(?,?,?,?)');
		    $ps->execute(array($com2, $id, $u, @date('Y-m-d H:i:s')));
		    echo '<script>window.location.replace("index.php?id=2")</script>'; // предотвращаем повторную отправку формы
		  }

		  function getCom2($id) // метод для получения всех ком-риев к комментарию с данным id
		 {	
		 	$com1=array();
		 	$db=connectPDO();
		 	$res=$db->query('select * from Comments2 where comm1id='.$id);
		 	while($row=$res->fetch())
		 	{
		 		$com2[]=$row;
		 	}
		 	return $com2;
		 }

		  function drawCom2($userid, $com2, $date) // метод для вывода ком-ия к ком-ию по его id
		  {	
		  	$u=User::userFromDB_id($userid);
		 	$u->userInfo(); // метод для вывода информации о пол-ле
		 	echo '<hr>';
			echo '<p>'.$com2.'</p>'; //выводим сообщение
			echo '<p class="datemess">'.$date.'</p>'; //выводим время сообщения
			echo '<hr>';

		  }
	}

 ?>

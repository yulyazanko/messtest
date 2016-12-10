
<!-- <h3>Страница сообщений</h3> -->
<div class="messages">

<form action="index.php?id=2" method="POST" class="form-group col-lg-8 col-lg-offset-2 col-sm-12">

<?php 
	include_once('pages/classes.php');
	
	if(isset($_SESSION['authuser'])) //если в сессии есть зарегестрированный пол-ль, рисуем форму отправки сообщения
	{
		
		//echo $_SESSION['authuser'];
		$user=User::userFromDB($_SESSION['authuser']); //создаем объект с данными из БД (по его facebook-id)
		$user->userInfo(); //Выводим инф-ию о пол-ле 

 ?>
	
	<textarea class="form-control " name="message" rows="4"></textarea><br>
	
	<div class="form-group col-lg-6">
		<input type="submit" class="form-control btn btn-success" name="addmes" value="Добавить сообщение">
	</div>

	<div class="form-group col-lg-6">
	<input type="reset" class="form-control btn btn-warning" name="reset" value="Отменить"><br>
	</div>


<?php 
	}
	else
	{
		echo '<h3>Войдите через свой аккаунт в Facebook и общайтесь на здоровье!</h3>';
		echo '<div class="auth">';
		echo '<a href="index.php?id=1" class="btn btn-social btn-facebook"><span class="fa fa-facebook"></span>Авторизоваться</a>';
		echo '</div>';
	}
	
?>
	<div class="messList">
		<?php

		echo '<ul class="mess col-lg-12">';
		 $list=Message::getMessList();
		 foreach($list as $m)
		 {	
		 	echo '<li>';
		 	$m->drawMess();

		 	if(isset($_SESSION['authuser'])) // если есть зарег-ый пол-ль
		 	{
 		   	  $m->addCom1(); // добавляем поле ввода ком-ия и кнопку (пока скрытое)
 		   	}	
 		   	 
		 	  echo '<ul>';
		 	    $com1=$m->getCom1(); //получаем все ком-ии к данному сооб-ию
		 	    foreach($com1 as $c1) // перебираем массив с коммен-ями
		 	    { 	
		 	    	echo '<li>';
		 	    	$m->drawCom1($c1['userid'],  $c1['comment1'], $c1['datecomm']); // выводим комментарий
		 	    	if(isset($_SESSION['authuser'])) //если есть авторизированный пол-ль
		 	    	{
						$m->addCom2($c1['id']); // выводим поле для добавления комментария к комментарию и кнопку (пока скрытое)
		 	    	}
		 	    	
		 	    	  echo '<ul>';
		 	    	  	$com2=$m->getCom2($c1['id']); //получаем все ком-ии к данному ком-ию
		 	    	  	if(isset($com2))
		 	    	  	{
		 	    	  		foreach($com2 as $c2) //перебираем массив с коммен-ями к ком-ям
		 	    	  		{
		 	    	  			echo '<li>';
		 	    	  			$m->drawCom2($c2['userid'],  $c2['comment2'], $c2['datecomm']); // выводим комментарий к комментарию
		 	    	  			echo '</li>';
		 	    	  		}
		 	    	  	}
		 	    	  	
		 	    	  		 	    
		 	    	  echo '</ul>';
		 	    	echo '</li>';
		 	    }
		 	   
		 	  echo '</ul>';
		 	
		 	echo '</li>';
		 	
		 }
		 echo '</ul>';
		?>
		
				
		
	</div>

<?php
	if(isset($_REQUEST['addmes'])) // если нажата кнопка с именем addmes
	{
		$mess=trim(htmlspecialchars($_REQUEST['message'])); //обезопасиваем сообщение
		if(empty($mess)) return false; //предотвращаем отправку пустого сообщения
		$user_id=$_SESSION['authuser']; // получаем фейсбук-id пол-ля 
		Message::messIntoDB($mess, $user_id); //добавляем сообщение в БД
	}

 ?>

	</form>
 </div>


 <?php 
 	if(isset($_REQUEST))
 	{
 		foreach($_REQUEST as $k=> $v) //перебираем массив $_REQUEST, чтобы узнать, какая кнопка была нажата
 		{
 			if(substr($k, 0, 7) == 'addcom1') //если нажата кнопка, имя кот. начинается на addcom1
 			{
 				$idd= substr($k, 7); //получаем из имени id сообщения, к кот. пол-ль добавил ком-ий
 				$com=trim(htmlspecialchars($_REQUEST['com1_'.$idd])); //обезопасиваем сообщение
 				if(empty($com)) return false; //предотвращаем отправку пустого ком-ия
 				$com1= Message::messFromDB($idd); // получаем сообщение по его id
 				$com1->com1IntoDB($com); //добавляем ком-ий в БД
 			}
 		}
 	}

 	if(isset($_REQUEST))
 	{
 		foreach($_REQUEST as $k=> $v) //перебираем массив $_REQUEST, чтобы узнать, какая кнопка была нажата
 		{
 			if(substr($k, 0, 7) == 'addcom2') //если нажата кнопка, имя кот. начинается на addcom2
 			{
 				$idd= substr($k, 7); //получаем из имени id ком-ия, к кот. пол-ль добавил ком-ий
 				$com=trim(htmlspecialchars($_REQUEST['com2_'.$idd])); //обезопасиваем сообщение
 				if(empty($com)) return false; //предотвращаем отправку пустого ком-ия
 				Message::com2IntoDB($com, $idd); //добавляем ком-ий в БД
 			}
 		}
 	}





  ?>
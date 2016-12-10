
<h3>Войдите через свой аккаунт в Facebook и общайтесь на здоровье!</h3>

	<?php 

		unset($_SESSION['authuser']);
	
	  // Записываем данные, полученные при регистрации приложения в специальные переменные
		$client_id = '688163031359508'; // Client ID
		$client_secret = '6910345854294dede2ba7ca914fb040b'; // Client secret
		$redirect_uri = 'http://localhost/messtest'; // Redirect URIs


		//генерируем ссылку c помощью функции http_build_query, передав туда массив параметров для получения значения  параметра code

		$url = 'https://www.facebook.com/dialog/oauth';

		$params = array(
		    'client_id'     => $client_id,
		    'redirect_uri'  => $redirect_uri,
		    'response_type' => 'code',
		    'scope'         => 'email,user_birthday'
		);
		echo '<div class="row auth">';
		echo $link = '<a href="' . $url . '?' . urldecode(http_build_query($params)) . '" class="btn btn-social btn-facebook lg-col-6"><span class="fa fa-facebook"></span>Войдите через Facebook</a>';
		echo '</div>';
		

		// снова сформируем параметры для запроса авторизации

		if (isset($_GET['code'])) 
		{
		    $result = false;

		    $params = array(
		        'client_id'     => $client_id,
		        'redirect_uri'  => $redirect_uri,
		        'client_secret' => $client_secret,
		        'code'          => $_GET['code'],
		        // 'id'            =>  $_GET['id']
		    );

	    	$url = 'https://graph.facebook.com/oauth/access_token';
		}


		// распарсим ответ фейсбука, с помощью функции parse_str, результат (в виде массива) запишем в переменную $tokenInfo

		$tokenInfo = null;
		parse_str(@file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);


		//делаем запрос к Facebook API для получения информации о пользователе, передавая параметр access_token

		if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) 
		{
	        $params = array('access_token' => $tokenInfo['access_token']);

        //Отправляем GET запрос по адресу https://graph.facebook.com/me.
	        $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);
	        if (isset($userInfo['id'])) {
	            $userInfo = $userInfo;
	            $result = true;
	        }
	       

		    if ($result) 
		    {	
		    	// узнаем есть ли в БД такой пользователь
		    	$res=$pdo->query('select user_id from users');
		    	while($row=$res->fetch())
		    	{  
		    		if($row['user_id']==$userInfo['id'])// если есть, записываем его id в сессию
		    		{
		    			$_SESSION['authuser']=$userInfo['id']; 
		    			echo '<script>window.location.replace("index.php?id=2")</script>';
		    			echo 'Уже зарегестрирован';
		    			//return;
		    		}
		    	// если такого пол-ля нет (в сеесию ничего не занеслось) записываем его данные в БД
		    	}		
		    		if(!isset($_SESSION['authuser']))
		    		{	
		    			//echo 'Нет в базе данных';
		    			$path='http://graph.facebook.com/' . $userInfo['id'] . '/picture?type=large"';
		    			$link='http://facebook.com/'.$userInfo['id'];
		    			$u= new User($userInfo['id'], $userInfo['name'], $link, $path);
		    			$u->userIntoDB();
		    			$_SESSION['authuser']=$userInfo['id']; 
		    			echo '<script>window.location.replace("index.php?id=2")</script>';
		    		}
		     		    	
			}

			
	    }
			
	         

  	?>
	
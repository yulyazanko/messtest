<?php 
	session_start();

	include_once('pages/functions.php');
	include_once('pages/classes.php');
	$pdo=connectPDO();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Messtest</title>
	<link rel="icon" href="image/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-social.css" />
	<link rel="stylesheet" href="css/font-awesome.css" >
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
	   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->

	<link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<main class="container">
	<?php 
	
			if(isset($_GET['id']))
			{
			 	$id=$_GET["id"];
			 	if($id==1)
					include_once('pages/auth.php');
				if($id==2)
			 		include_once('pages/messages.php');
			}
			else{
				    include_once('pages/auth.php');
				}
				

			
			   
	?>

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button class="navbar-toggle pull-left" data-toggle="collapse" data-target="#top_menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div id="top_menu" class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php 
						if(!isset($_SESSION['authuser'])) //меняем пункты меню в зависимости от того, есть ли авторизированный пол-ль и на какой он странице
						{	
							switch($_GET['id'])
							{
								case 2 : 
									echo '<li><a href="index.php?id=1"><span class="fa fa-facebook"></span> Авторизация на Facebook</a></li>'; 
									break;
								case 1 : 
									echo '<li><a href="index.php?id=2"><span class="fa fa-facebook"></span> Войти без авторизации</a></li>';
									break;
								default :
									echo '<li><a href="index.php?id=2"><span class="fa fa-facebook"></span> Войти без авторизации</a></li>';
										
							}
						}
						else
						{	
							switch($_GET['id'])
							{
								case 1 :
								  echo '<li><a href="index.php?id=2"><span class="fa fa-facebook"></span> Войти без авторизации</a></li>';
								  break;
								case 2:
								  echo '<li><a href="index.php?id=1"><span class="fa fa-facebook"></span> Авторизация на Facebook</a></li>';
								  break;
							}
													
						}
						
					 ?>

									
				</ul>
			</div>

		</div>
	</nav>
	

	</main>
</body>
</html>

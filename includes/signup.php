<?php

	include('../core/init.php');

	$user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);

	if (isset($_GET['step']) === true && empty($_GET['step']) === false ) 
	{
 		 if (isset($_POST['next'])) 
 		 {
 		 	$username = $getFromU->checkInput($_POST['username']);

 		 	if (!empty($username)) 
 		 	{
 		 		if (strlen($username) > 20) 
 		 		{
 		 			$error = "Usuário deve conter entre 6 a 20 caracteres";
 		 		}
 		 		else if ($getFromU->checkUsername($username) === true) 
 		 		{
 		 			$error = "Usuário já está em uso!";
 		 		}
 		 		else
 		 		{
 		 			$getFromU->update('users', $user_id, array('username' => $username));
 		 			header('Location: signup.php?step=2');
 		 		}
 		 	}
 		 	else 
 		 	{
 		 		$error = "Por favor entre com seu Usuário";
 		 	}
 		 }
	}
?>

<!doctype html>
<html>
	<head>
		<title>twitter</title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="assets/css/font/css/font-awesome.css"/>
		<link rel="stylesheet" href="../assets/css/style-complete.css"/>
	</head>
	<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- nav wrapper -->
	<div class="nav-wrapper">
		
		<div class="nav-container">	
			<div class="nav-second">
				<ul>
					<li><a href="#"<i class="fa fa-twitter" aria-hidden="true"></i></a></li>							
				</ul>
			</div><!-- nav second ends-->
		</div><!-- nav container ends -->

	</div><!-- nav wrapper end -->

	<!---Inner wrapper-->
	<div class="inner-wrapper">
		<!-- main container -->
		<div class="main-container">
			<!-- step wrapper-->
			<?php

				if ($_GET['step'] == '1')
				{
					
			?>
		 		<div class="step-wrapper">
				    <div class="step-container">
						<form method="post">
							<h2>Escolha um Usuário</h2>
							<h4>Não se preocupe, você pode sempre mudar em qualquer momento.</h4>
							<div>
								<input type="text" name="username" placeholder="Usuário"/>
							</div>
							<div>
								<ul>
								  <li>
								  	<?php 

								  		if (isset($error)) 
								  		{
								  			echo $error;
								  		} 
								  	?>						  	
								  </li>
								</ul>
							</div>
							<div>
								<input type="submit" name="next" value="Próximo"/>
							</div>
						 </form>
					</div>
				</div>
		  	<?php
		  		}
		  	?>

		  	<?php  
		  		if ($_GET['step'] == '2') 
		  		{
		  			
		  	?>
				<div class='lets-wrapper'>
					<div class='step-letsgo'>
						<h2>Estamos felizes por você estar aqui, 
							<?php 
								echo $user->screenname;
							?> 
						</h2>
						<p>O TwitThel é um fluxo de informação constante e atualizado das notícias mais importantes e legais, da mídia, dos esportes, conversas e muito mais - tudo feito sob medida para você.</p>
						<br/>
						<p>
							Conte-nos sobre todas as coisas que você ama e nós o ajudaremos a se preparar.
						</p>
						<span>
							<a href='../home.php' class='backButton'>Vamos nessa!</a>
						</span>
					</div>
				</div>
	  	
		  	<?php 
		  		}
		  	?>
			
		</div><!-- main container end -->

	</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->

</body>
</html>

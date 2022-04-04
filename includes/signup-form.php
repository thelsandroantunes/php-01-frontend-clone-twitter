<?php
	
	if (isset($_POST['signup'])) 
	{
		$screenName = $_POST['screenName'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$error = '';

		if (empty($screenName) or empty($email) or empty($password)) 
		{
			$error = "Todos os campos são necessários";
		}
		else
		{
			$screenName = $getFromU->checkInput($screenName);
			$email = $getFromU->checkInput($email);
			$password = $getFromU->checkInput($password);

			if (!filter_var($email)) 
			{
				$error = "Formato de Email Inválido";
			}
			else if (strlen($screenName) > 20) 
			{
				$error = "Nome deve estar entre 6 a 20 caracteres";
			}
			else if (strlen($password) < 5) 
			{
				$error = "A senha é muito curta";
			}
			else
			{
				if ($getFromU->checkEmail($email)) 
				{
					$error = "Email já está em uso";
				}
				else
				{
				
					$user_id = $getFromU->create('users', array( 
													 'email' => $email,
													 'password' => md5($password),
													 'screenname' => $screenName,
													 'profileimage' => 'assets/images/defaultprofileimage.png',
													 'profilecover' => 'assets/images/defaultCoverImage.png'
													));
					$_SESSION['user_id'] = $user_id;

					header("Location: includes/signup.php?step=1");
				}
			}
		}
	}

?>

<form method="post">
<div class="signup-div"> 
	<h3>Inscreva-se </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Nome"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Senha"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Inscreva-se no TwitThel">
		</li>
	</ul>
	
	<?php

		if ( isset($error))
		{
			echo'<li class="error-li">
				 	<div class="span-fp-error">'. $error .'</div>
				 </li> ';
		}
	?>
	 
	
</div>
</form>
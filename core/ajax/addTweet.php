<?php

	include '../init.php';

	if (isset($_POST) && !empty($_POST)) {
		$status		= $getFromU->checkInput($_POST['status']);
		$user_id	= $_SESSION['user_id'];
		$tweetimage	= '';

		if (!empty($status) or !empty($_FILES['file']['name'][0])) 
		{
			if (!empty($_FILES['file']['name'][0])) 
			{
				$tweetImage = $getFromU->uploadImage($_FILES['file']);
			}

			if (strlen($status) > 140) 
			{
				$error = "O texto do seu twitter é muito longo.";
			}

			$getFromU->create('tweets', 
							   array('status' => $status, 
									 'tweetby' => $user_id,
									 'tweetimage' => $tweetImage,
									 'postedon' => date('Y-m-d H:i:s')));
			preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);

			if (!empty($hashtag)) 
			{
				$getFromT->addTrend($status);
			}
			$result['success'] = "Seu Tweet foi postado";
			echo json_encode($result);
		}
		else
		{
			$error = "Digite ou escolha a imagem para twittar";
		}

		if (isset($error)) {
			$result['error'] = $error;
			echo json_encode($result);
		}
	}

?>
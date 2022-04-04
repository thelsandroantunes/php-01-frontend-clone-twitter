<?php

	include("core/init.php");

	if ($getFromU->loggedIn() === false) 
	{
		header('Location: index.php');
	}
	
	$user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);

	if (isset($_POST['screenName'])) 
	{
		if (!empty($_POST['screenName'])) 
		{
			$screenName = $getFromU->checkInput($_POST['screenName']);
			$profileBio = $getFromU->checkInput($_POST['bio']);
			$country    = $getFromU->checkInput($_POST['country']);
			$website    = $getFromU->checkInput($_POST['website']);

			if (strlen($screenName) > 20) 
			{
				$error = "Nome deve conter entre 6 a 20 caracteres";
			}
			else if (strlen($profileBio) > 120) 
			{
				$error = "Descrição é muito longa";
			}
			else if (strlen($country) > 80) 
			{
				$error = "Nome do país é muito longa";
			}
			else
			{
				$getFromU->update('users', $user_id, array('screenname' => $screenName, 
														   'bio' => $profileBio, 
														   'country' => $country, 
														   'website' => $website));
				header('Location: '.$user->username);
			}
		}
		else
		{
			$error = "O campo nome não pode ficar vazio";
		}
	}

	if (isset($_FILES['profileImage'])) 
	{
		if (!empty($_FILES['profileImage']['name'][0])) 
		{
			$fileRoot = $getFromU->uploadImage($_FILES['profileImage']);
			$getFromU->update('users', $user_id, array('profileimage' => $fileRoot));
			header('Location: '.$user->username);
		}
	}

	if (isset($_FILES['profileCover'])) 
	{
		if (!empty($_FILES['profileCover']['name'][0])) 
		{
			$fileRoot = $getFromU->uploadImage($_FILES['profileCover']);
			$getFromU->update('users', $user_id, array('profilecover' => $fileRoot));
			header('Location: '.$user->username);
		}
	}

?>


<!doctype html>
<html>
<head>
	<title>Editar perfil</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
	<link rel="stylesheet" href="assets/css/style-complete.css"/>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
				integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
				crossorigin="anonymous">		
	</script>
</head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
	<!-- header wrapper -->
<div class="header-wrapper">

<div class="nav-container">
	<!-- Nav -->
	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notificação</a></li>
				<li><i class="fa fa-envelope" aria-hidden="true"></i>Mensages</li>
			</ul>
		</div>
		<!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
				<div class="search-result">
					 			
				</div></li>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo $user->profileimage; ?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo $user->username; ?>"><?php echo $user->username; ?></a></li>
							<li><a href="settings/account">Configuração</a></li>
							<!--<li><a href="includes/logout.php">Sair</a></li>-->
							<li><a href="<?php echo BASE_URL; ?>includes/logout.php">Sair</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet" class="addTweetBtn">Tweet</label></li>
			</ul>
		</div>
		<!-- nav right ends-->
	</div>
	<!-- nav ends -->
</div>
<!-- nav container ends -->
</div>
<!-- header wrapper end -->

<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
	   <!-- PROFILE-COVER -->
		<img src="<?php echo $user->profilecover; ?>"/>
 
		<div class="img-upload-button-wrap">
			<div class="img-upload-button1">
				<label for="cover-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text1">
					Altere sua foto de perfil
				</span>
				<input id="cover-upload-btn" type="checkbox"/>
				<div class="img-upload-menu1">
					<span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="file-up">
									Upload foto
								</label>
								<input type="file" name="profileCover" onchange="this.form.submit();" id="file-up" />
							</li>
								<li>
								<label for="cover-upload-btn">
									Cancelar
								</label>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="profile-nav">
	<div class="profile-navigation">
		<ul>
			<li>
				<a href="#">
					<div class="n-head">
						TWEETS
					</div>
					<div class="n-bottom">
					<?php 
						$getFromT->countTweets($user_id);

					?>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL.$user->username.'/following';?>">
					<div class="n-head">
						FOLLOWINGS
					</div>
					<div class="n-bottom">
						<?php echo $user->following; ?>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo BASE_URL.$user->username.'/followers';?>">
					<div class="n-head">
						FOLLOWERS
					</div>
					<div class="n-bottom">
						<?php echo $user->followers; ?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						LIKES
					</div>
					<div class="n-bottom">
						<?php $getFromT->countLikes($user_id); ?>
					</div>
				</a>
			</li>
			
		</ul>
		<div class="edit-button">
			<span>
				<button class="f-btn" type="button" onclick="window.location.href='<?php echo $user->username; ?>';" value="Cancelar">Cancelar</button>
			</span>
			<span>
				<input type="submit" id="save" value="Salvar">
			</span>
		 
		</div>
	</div>
</div>
</div><!--Profile Cover End-->

<div class="in-wrapper">
<div class="in-full-wrap">
  <div class="in-left">
	<div class="in-left-wrap">
		<!--PROFILE INFO WRAPPER END-->
<div class="profile-info-wrap">
	<div class="profile-info-inner">
		<div class="profile-img">
			<!-- PROFILE-IMAGE -->
			<img src="<?php echo $user->profileimage; ?>"/>
 			<div class="img-upload-button-wrap1">
			 <div class="img-upload-button">
				<label for="img-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text">
					Altere sua foto de perfil
				</span>
				<input id="img-upload-btn" type="checkbox"/>
				<div class="img-upload-menu">
				 <span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="profileImage">
									Upload photo
								</label>
								<input id="profileImage" type="file" onchange="this.form.submit();"  name="profileImage"/>
								
							</li>
							<li><a href="#">Remover</a></li>
							<li>
								<label for="img-upload-btn">
									Cancelar
								</label>
							</li>
						</ul>
					</form>
				</div>
			  </div>
			  <!-- img upload end-->
			</div>
		</div>

			    <form id="editForm" method="post" enctype="multipart/Form-data">	
					<div class="profile-name-wrap">
						<?php

							if (isset($imageError)) 
							{
								echo '<ul>
					 					 <li class="error-li">
										 	 <div class="span-pe-error">'.$imageError.'</div>
										 </li>
									 </ul>  ';
							}
						?>
						 
						<div class="profile-name">
							<input type="text" name="screenName" value="<?php echo $user->screenname; ?>"/>
						</div>
						<div class="profile-tname">
							@<?php echo $user->username; ?>
						</div>
					</div>
					<div class="profile-bio-wrap">
						<div class="profile-bio-inner">
							<textarea class="status" name="bio"><?php echo $user->bio; ?></textarea>
							<div class="hash-box">
						 		<ul>
						 		</ul>
						 	</div>
						</div>
					</div>
					<div class="profile-extra-info">
						<div class="profile-extra-inner">
							<ul>
								<li>
									<div class="profile-ex-location">
										<input id="cn" type="text" name="country" placeholder="País" value="<?php echo $user->country; ?>" />
									</div>
								</li>
								<li>
									<div class="profile-ex-location">
										<input type="text" name="website" placeholder="Website" value="<?php echo $user->website; ?>"/>
									</div>
								</li>

					<?php

						if (isset($error)) 
						{
							echo '<li class="error-li">
								 	 <div class="span-pe-error">'.$error.'</div>
								  </li>
								 ';
						}
					?>
				</form>
				<script type="text/javascript">
					$('#save').click(function(){
						$('#editForm').submit();
					})
				</script>
							</ul>						
						</div>
					</div>
				<div class="profile-extra-footer">
					<div class="profile-extra-footer-head">
						<div class="profile-extra-info">
							<ul>
								<li>
									<div class="profile-ex-location-i">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</div>
									<div class="profile-ex-location">
										<a href="#">0 Fotos e vídeos </a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="profile-extra-footer-body">
						<ul>
						  <!-- <li><img src="#"></li> -->
						</ul>
					</div>
				</div>
			</div>
			<!--PROFILE INFO INNER END-->
		</div>
		<!--PROFILE INFO WRAPPER END-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">	
		<?php 
			$tweets = $getFromT->getUserTweets($user_id);

			foreach ($tweets as $tweet) 
			{
				$likes = $getFromT->likes($user_id, $tweet->tweetid);				
				$retweet = $getFromT->checkRetweet($tweet->tweetid, $user_id);
				$user = $getFromU->userData($tweet->retweetby);

				echo'
					<div class="all-tweet">
						<div class="t-show-wrap">	
							<div class="t-show-inner">
								'.(($retweet['retweetid'] === $tweet->retweetid or $tweet->retweetid > 0) ? '
								<div class="t-show-banner">
									<div class="t-show-banner-inner">
										<span><i class="fa fa-retweet" aria-hidden="true"></i></span>
										<span>'.$user->screenname.' Retweeted</span>
									</div>
								</div>' 
								
								: '').'

								'.((!empty($tweet->retweetmsg) && $tweet->tweetid === $retweet['tweetid'] or $tweet->retweetid > 0 ) ? 
								'<div class="t-show-popup" data-tweet="'.$tweet->tweetid.'">
									<div class="t-show-head">
										<div class="t-show-img">
											<img src="' .BASE_URL.$user->profileimage. '"/>
										</div>
										<div class="t-s-head-content">
											<div class="t-h-c-name">
												<span>
													<a href= "' .BASE_URL.$user->username. '" > ' .$user->screenname. '</a>
												</span>
												<span>@'.$user->username.'</span>
												<span>'.$getFromU->timeAgo($retweet['postedon']).'</span>
											</div>
											<div class="t-h-c-dis">
												'.$getFromT->getTweetLinks($tweet->retweetmsg).'
											</div>
										</div>
									</div>
									<div class="t-s-b-inner">
										<div class="t-s-b-inner-in">
											<div class="retweet-t-s-b-inner">
												'.((!empty($tweet->tweetimage)) ? '
												<div class="retweet-t-s-b-inner-left">
													<img src="'.BASE_URL.$tweet->tweetimage.'" class="imagePopup" data-tweet="'.$tweet->tweetid.'"/>	
												</div>' 
												
												: '').'

												<div >
													<div class="t-h-c-name">
														<span><a href="'.BASE_URL.$tweet->username.'">'.$tweet->screenname.'</a></span>
														<span>@'.$tweet->username.'</span>
														<span>'.$getFromU->timeAgo($tweet->postedon).'</span>
													</div>
													<div class="retweet-t-s-b-inner-right-text">		
														'.$getFromT->getTweetLinks($tweet->status).'
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								' : '

								<div class="t-show-popup" data-tweet="'.$tweet->tweetid.'">
									<div class="t-show-head">
										<div class="t-show-img">
											<img src="'.BASE_URL.$tweet->profileimage.'"/>
										</div>
										<div class="t-s-head-content">
											<div class="t-h-c-name">
												<span><a href="'.$tweet->username.'">'.$tweet->screenname.'</a></span>
												<span>@'.$tweet->username.'</span>
												<span>'.$getFromU->timeAgo($tweet->postedon).'</span>
											</div>
											<div class="t-h-c-dis">
												'.$getFromU->getTweetLinks($tweet->status).'
											</div>
										</div>
									</div>

									'.

									 ((!empty($tweet->tweetimage)) ? 
									 
									 	'<!--tweet show head end-->
											<div class="t-show-body">
											  <div class="t-s-b-inner">
											   <div class="t-s-b-inner-in">
											     <img src="'.BASE_URL.$tweet->tweetimage.'" class="imagePopup" data-tweet="'.$tweet->tweetid.'"/>
											   </div>
											  </div>
											</div>
											<!--tweet show body end-->
										' : ''). 
							   '</div>').'

								<div class="t-show-footer">
									<div class="t-s-f-right">
										<ul> 
											<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
											
											<li>'.(($tweet->tweetid === $retweet['retweetid'] OR $user_id == $retweet['retweetby'] ) ? 
												'<button class="retweeted" data-tweet="'.$tweet->tweetid.'" data-user="'.$tweet->tweetby.'">
													<a href="#">
														<i class="fa fa-retweet" aria-hidden="true"></i>
													</a>
													<span class="retweetsCount">'.$tweet->retweetcount.'</span>
												</button>' 
												
												: 
												
												'<button class="retweeted" data-tweet="'.$tweet->tweetid.'" data-user="'.$tweet->tweetby.'">
													<a href="#">
														<i class="fa fa-retweet" aria-hidden="true"></i>
													</a>
													<span class="retweetsCount">'.(($tweet->retweetcount > 0) ? $tweet->retweetcount : '').'</span>
												</button>' )).'												
											</li>
											
											<li>'.(($likes['likeon'] === $tweet->tweetid) ? 
												'<button class="unlike-btn" data-tweet="'.$tweet->tweetid.'" data-user="'.$tweet->tweetby.'">
												 	<a href="#">
												 		<i class="fa fa-heart" aria-hidden="true"></i>
												 	</a>
												 	<span class="likesCounter">'.$tweet->likescount.'</span>
												 </button>' : 
												'<button class="like-btn" data-tweet="'.$tweet->tweetid.'" data-user="'.$tweet->tweetby.'">
												 	<a href="#">
												 		<i class="fa fa-heart-o" aria-hidden="true"></i>
												 	</a>
												 	<span class="likesCounter">'.(($tweet->likescount > 0) ? $tweet->likescount : '').'</span>
												 </button>').'
											</li>

											'.(($tweet->tweetby === $user_id) ? '
																						
											<li><a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
												<ul> 
											  		<li><label class="deleteTweet" data-tweet="'.$tweet->tweetid.'">Delete Tweet</label></li>
												</ul>
											</li>' : '').'
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}	
		?>
	</div>
	<!-- in left wrap-->
   <div class="popupTweet"></div>

	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popuptweets.js"></script>
	<script type="text/javascipt" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
	<script type="text/javascipt" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
	<script type="text/javascipt" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
	<script type="text/javascipt" src="<?php echo BASE_URL;?>assets/js/fetch.js"></script>
	<script type="text/javascipt" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
	<script type="text/javascipt" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>

</div>
<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">
		<!--==WHO TO FOLLOW==-->
           <!-- HERE -->
		<!--==WHO TO FOLLOW==-->
			
		<!--==TRENDS==-->
 	 	   <!-- HERE -->
	 	<!--==TRENDS==-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in right end -->

   </div>
   <!--in full wrap end-->
 
  </div>
  <!-- in wrappper ends-->

</div>
<!-- ends wrapper -->
</body>
</html>
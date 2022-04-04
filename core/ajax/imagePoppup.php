<?php
	include '../init.php';
	if (isset($_POST['showImage']) && !empty($_POST['showImage'])) {
		$tweet_id 	= $_POST['showImage'];
		$user_id	= $_SESSION['user_id'];
		$tweet_id	= $getFromT->getPopupTweet($tweet_id);
		$likes		= $getFromT->likes($user_id, $tweet_id);
		$retweet	= $getFromT->checkRetweet($tweet_id, $user_id);

		?>
		<div class="img-popup">
			<div class="wrap6">
			<span class="colose">
				<button class="close-imagePopup"><i class="fa fa-times" aria-hidden="true"></i></button>
			</span>
			<div class="img-popup-wrap">
				<div class="img-popup-body">
					<img src="<?php echo BASE_URL.$tweet->tweetimage; ?>"/>
				</div>
				<div class="img-popup-footer">
					<div class="img-popup-tweet-wrap">
						<div class="img-popup-tweet-wrap-inner">
							<div class="img-popup-tweet-left">
								<img src="<?php echo BASE_URL.$tweet->profileimage; ?>"/>
							</div>
							<div class="img-popup-tweet-right">
								<div class="img-popup-tweet-right-headline">
									<a href="<?php echo BASE_URL.$tweet->username; ?>"><?php $tweet->screenname; ?></a><span>@<?php $tweet->screenname.'-'.$tweet->postedon; ?></span>
								</div>
								<div class="img-popup-tweet-right-body">
									<?php echo $getFromT->getTweetLinks($tweet->status);?>
								</div>
							</div>
						</div>
					</div>
					<div class="img-popup-tweet-menu">
						<div class="img-popup-tweet-menu-inner">
						  	<ul> 
						  		<?php
						  			if ($getFromU->loggedIn() === true) {
						  				echo '<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
											
											<li>'.(($tweet->tweetid === $retweet['retweetid'] ? 
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

											<li><
												label for="img-popup-menu">
													<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
												</label>
												<input id="img-popup-menu" type="checkbox"/>
												<div class="img-popup-footer-menu">
													<ul><li><label class="deleteTweet" data-tweet="'.$tweet->tweetid.'" >Delete Tweet</label></li></ul>
												</div>
											</li>' : '' );
						  			}else{
						  				echo '<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
											  <li><button class="retweet"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount"></span></button></li>
											  <li><button class="like-btn"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter"></span></button></li>';
						  			}
						  		?>
								
								
								
							</ul>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div><!-- Image PopUp ends-->

		<?php
	}

?>


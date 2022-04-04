<?php 

	class Tweet extends User
	{
		
		function __construct($pdo)
		{
			$this->pdo = $pdo;
		}

		public function tweets($user_id, $num)
		{
			$stmt = $this->pdo->prepare("SELECT * FROM tweets
										 LEFT JOIN users
										 ON tweetby = user_id
										 WHERE tweetby = :user_id 
										 AND retweetid = 0
										 OR tweetby = :user_id 
										 AND retweetby != :user_id 
										 LIMIT :num");
			$stmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindParam('num', $num, PDO::PARAM_INT);
			$stmt->execute();
			$tweets = $stmt->fetchAll(PDO::FETCH_OBJ);



			foreach ($tweets as $tweet) 
			{
				$likes = $this->likes($user_id, $tweet->tweetid);				
				$retweet = $this->checkRetweet($tweet->tweetid, $user_id);
				$user = $this->userData($tweet->retweetby);

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
												<span>'.$this->timeAgo($retweet['postedon']).'</span>
											</div>
											<div class="t-h-c-dis">
												'.$this->getTweetLinks($tweet->retweetmsg).'
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
														<span>'.$this->timeAgo($tweet->postedon).'</span>
													</div>
													<div class="retweet-t-s-b-inner-right-text">		
														'.$this->getTweetLinks($tweet->status).'
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
											<img src="'.$tweet->profileimage.'"/>
										</div>
										<div class="t-s-head-content">
											<div class="t-h-c-name">
												<span><a href="'.$tweet->username.'">'.$tweet->screenname.'</a></span>
												<span>@'.$tweet->username.'</span>
												<span>'.$this->timeAgo($tweet->postedon).'</span>
											</div>
											<div class="t-h-c-dis">
												'.$this->getTweetLinks($tweet->status).'
											</div>
										</div>
									</div>

									'.

									 ((!empty($tweet->tweetimage)) ? 
									 
									 	'<!--tweet show head end-->
											<div class="t-show-body">
											  <div class="t-s-b-inner">
											   <div class="t-s-b-inner-in">
											     <img src="'.$tweet->tweetimage.'" class="imagePopup" data-tweet="'.$tweet->tweetid.'"/>
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
		}

		public function getTrendByHash($hashtag)
		{
			$stmt = $this->pdo->prepare("SELECT * FROM trends
										 WHERE hashtag
										 LIKE :hashtag LIMIT 5");
			$stmt->bindValue(':hashtag', $hashtag.'%');
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function getMention($mention)
		{
			$stmt = $this->pdo->prepare("SELECT user_id, username, screenname, profileimage
										 FROM users
										 WHERE username
										 LIKE :mention OR screenname
										 LIKE :mention LIMIT 5");
			$stmt->bindValue(':mention', $mention.'%');
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function addTrend($hashtag)
		{
			preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $metches);

			if ($metches) 
			{
				$result = array_values($metches[1]);				
			}

			$sql = "INSERT INTO trends (hashtag, createdon)
					VALUES (:hashtag, CURRENT_TIMESTAMP)";
			foreach ($result as $trend) 
			{
				if ($stmt = $this->pdo->prepare($sql)) 
				{
					$stmt->execute(array(':hashtag' => $trend));
				}
			}
		}

		public function getTweetLinks($tweet)
		{
			$tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $tweet);
			$tweet = preg_replace("/#([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>", $tweet);
			$tweet = preg_replace("/@([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>", $tweet);

			return $tweet;
		}

		public function getPopupTweet($tweet_id, $user_id)
		{
			$stmt = $this->pdo->prepare("SELECT * FROM tweets, users
										 WHERE tweetid = :tweet_id
										 AND tweetby = :user_id"); 
			$stmt->bindParam(':tweet_id', $tweet_id, PDO::PARAM_INT);
			$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function retweet($tweet_id,$user_id,$get_id,$comment)
		{
			$stmt = $this->pdo->prepare('UPDATE tweets 
										 SET retweetcount = retweetcount + 1
										 WHERE tweetid = :tweet_id');
			$stmt->bindParam(':tweet_id', $tweet_id, PDO::PARAM_INT);
			$stmt->execute();

			$stmt = $this->pdo->prepare('INSERT INTO tweets (status, tweetby, tweetimage, retweetid, retweetby, postedon, likescount, retweetcount, retweetmsg)
										 SELECT status, tweetby, tweetimage, tweetid, :user_id, postedon, likescount, retweetcount,:retweetMsg
										 FROM tweets
										 WHERE tweetid = :tweet_id');
			$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindParam(':retweetMsg', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':tweet_id', $tweet_id, PDO::PARAM_INT);
			$stmt->execute();

		}

		public function checkRetweet($tweet_id, $user_id)
		{
			$stmt = $this->pdo->prepare("SELECT * FROM tweets
										 WHERE retweetid = :tweet_id
										 AND retweetby = :user_id 
										 OR tweetid = :tweet_id
										 AND retweetby = :user_id");
			$stmt->bindParam('tweet_id', $tweet_id, PDO::PARAM_INT);
			$stmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function comments($tweet_id){
			$stmt = $this->pdo->prepare("SELECT * FROM comments
										 LEFT JOIN users
										 ON commentby = :user_id
										 WHERE commenton = :tweet_id");
			$stmt->bindParam('tweet_id', $tweet_id, PDO::PARAM_INT);
			$stmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_OBJ);
		}

		public function countTweets($user_id){
			$stmt = $this->pdo->prepare("SELECT COUNT(tweetid) 
										 AS totaltweets
										 FROM tweets
										 WHERE tweetby = :user_id
										 AND retweetid = 0
										 OR retweetby = :user_id");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

			$stmt->execute();
			$count = $stmt->fetch(PDO::FETCH_OBJ);

			echo $count->totaltweets;
		}

		public function countLikes($user_id){
			$stmt = $this->pdo->prepare("SELECT COUNT(likeid)
										 AS totallikes
										 FROM likes
										 WHERE likeby = :user_id");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

			$stmt->execute();
			$count = $stmt->fetch(PDO::FETCH_OBJ);

			echo $count->totallikes;
		}


		public function getUserTweets($user_id){
			$stmt = $this->pdo->prepare("SELECT * FROM tweets
										 LEFT JOIN users
										 ON tweetby = user_id
										 WHERE tweetby = :user_id
										 AND retweetid = 0
										 OR retweetby = :user_id");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_OBJ);
		}


		public function addLike($user_id, $tweet_id, $get_id)
		{
			$stmt = $this->pdo->prepare("UPDATE tweets 
										 SET likescount = likescount + 1
										 WHERE tweetid = :tweet_id");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT );
			$stmt->execute();

			$this->create('likes', array('likeby' => $user_id, 'likeon' => $tweet_id));
		}

		public function unlike($user_id, $tweet_id, $get_id)
		{
			$stmt = $this->pdo->prepare("UPDATE tweets  
										 SET likescount = likescount - 1
										 WHERE tweetid = :tweet_id");
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT );
			$stmt->execute();

			$stmt = $this->pdo->prepare("DELETE FROM likes
										 WHERE likeby = :user_id
										 AND likeon = :tweet_id");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();

		}

		public function likes($user_id, $tweet_id)
		{
			$stmt = $this->pdo->prepare("SELECT * FROM likes
										 WHERE likeby = :user_id
										 AND likeon = :tweet_id");
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
			$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
	}
?>
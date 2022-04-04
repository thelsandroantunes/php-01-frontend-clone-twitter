<?php
	
	$(function(){
		
		$(document).on('click', '.deleteTweet', function(){
			var $tweet_id = $(this).data('tweet');
			$.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/deleteTweet.php', {showPopup: tweet_id}, function(data){
				$('.popupTweet').html(data);
				$('.close-retweet-popup, .cancel-it').click(function(){
					$('.retweet-popup').hide();
				});

				$(document).on('click', '.delete-it', function(){
					$.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/deleteTweet.php', {deleteTweet: tweet_id}, function(){	
						$('.retweet-popup').hide();
						location.reload();
					});
				});
			});
		});

		$(document).on('click','.deleteComment', function(){
			var commentid = $(this).data('comment');
			var tweet_id = $(this).data('tweet');

			$.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/deleteComment.php', {deleteComment: commentid}, function(){
				$.post('http://localhost/WebDeveloper/Twitter-Clone/core/ajax/popuptweets.php', {showPopup: tweet_id}, function(data){
					$('.popupTweet').html(data);
            		$('.twweet-show-popup-box-cut').click(function(){
                		$('.twweet-show-popup-wrap').hide();
            		});
            	});
			});
		});
	});

?>
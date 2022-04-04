<?php
    include '../init.php';
    if(isset($_POST['showpopup']) && !empty($_POST['showpopup'])){
        $tweetid  = $_POST['showpopup'];
        $user_id  = $_SESSION['user_id'];
        $tweet    = $getFromT->getPopupTweet($tweetid);
        $user     = $getFromU->userData($user_id);
        $likes    = $getFromT->likes($user_id, $tweetid);
        $retweet  = $getFromT->checkRetweet($tweetid,$user_id);
        $comments = $getFromT->comments($tweetid);
    ?>
    
    <div class="tweet-show-popup-wrap">
        <input type="checkbox" id="tweet-show-popup-wrap">
        <div class="wrap4">
            <label for="tweet-show-popup-wrap">
                <div class="tweet-show-popup-box-cut">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </label>
            <div class="tweet-show-popup-box">
            <div class="tweet-show-popup-inner">
                <div class="tweet-show-popup-head">
                    <div class="tweet-show-popup-head-left">
                        <div class="tweet-show-popup-img">
                            <img src="<?php echo BASE_URL.$tweet->profileimage; ?>"/>
                        </div>
                        <div class="tweet-show-popup-name">
                            <div class="t-s-p-n">
                                <a href="<?php echo BASE_URL.$tweet->username; ?>">
                                    <?php echo $tweet->screenname; ?>
                                </a>
                            </div>
                            <div class="t-s-p-n-b">
                                <a href="<?php echo BASE_URL.$tweet->username; ?>">
                                <?php echo $tweet->username; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tweet-show-popup-head-right">
                        <button class="f-btn"><i class="fa fa-user-plus"></i> Follow </button>
                    </div>
                </div>
                <div class="tweet-show-popup-tweet-wrap">
                    <div class="tweet-show-popup-tweet">
                    <?php echo $getFromT->getTweetLinks($tweet->status); ?>
                    </div>
                    <div class="tweet-show-popup-tweet-ifram">
                        <?php if(!empty($tweet->tweetimage)){ ?>
                        <img src="<?php echo BASE_URL.$tweet->tweetimage; ?>"/> 
                        <?php }?>
                    </div>
                </div>
                <div class="tweet-show-popup-footer-wrap">
                    <div class="tweet-show-popup-retweet-like">
                        <div class="tweet-show-popup-retweet-left">
                            <div class="tweet-retweet-count-wrap">
                                <div class="tweet-retweet-count-head">
                                <?php echo $tweet->retweetcount; ?>
                                </div>
                                <div class="tweet-retweet-count-body">
                                    RETWEET-COUNT
                                </div>
                            </div>
                            <div class="tweet-like-count-wrap">
                                <div class="tweet-like-count-head">
                                    LIKES
                                </div>
                                <div class="tweet-like-count-body">
                                <?php echo $tweet->likescount; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tweet-show-popup-retweet-right">
                        
                        </div>
                    </div>
                    <div class="tweet-show-popup-time">
                        <span> <?php echo $tweet->postedon; ?></span>
                    </div>
                    <div class="tweet-show-popup-footer-menu">
                        <ul>
                        <?php if($getFromU->loggedIn() === true) { 
                                echo ' 	<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
                                                    
                                        <li>'.(($tweet->tweetid === $retweet['retweetid'] ? 
                                            '<button class="retweeted" data-tweet="'.$tweet->tweetid.'" data-user="'.$tweet->tweetby.'">
                                                <a href="#">
                                                    <i class="fa fa-retweet" aria-hidden="true"></i>
                                                </a>
                                                <span class="retweetsCount">'.$retweet->retweetcount.'</span>
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
                                        </li>' : '' );
                                }else{                                
                        ?>
                            <li><button type="buttton"><i class="fa fa-share" aria-hidden="true"></i></button></li>
                            <li><button type="button"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">RETWEET-COUNT</span></button></li>
                            <li><button type="button"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCount">LIKES-COUNT</span></button></button></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div><!--tweet-show-popup-inner end-->

            <?php if($getFromU->loggedIn() === true) { ?>
            <div class="tweet-show-popup-footer-input-wrap">
                <div class="tweet-show-popup-footer-input-inner">
                    <div class="tweet-show-popup-footer-input-left">
                        <img src="<?php echo BASE_URL.$user->profileimage; ?>"/>
                    </div>
                    <div class="tweet-show-popup-footer-input-right">
                        <input id="commentField" type="text" data-tweet="<?php echo $tweet->tweetid; ?>" name="comment"  placeholder="Reply to @<?php echo $tweet->username; ?>">
                    </div>
                </div>
                <div class="tweet-footer">
                    <div class="t-fo-left">
                        <ul>
                            <li>
                                <!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                <input type="file" id="t-show-file"> -->
                            </li>
                            <li class="error-li">
                            </li> 
                        </ul>
                    </div>
                    <div class="t-fo-right">
                        <input type="submit" id="postComment">
                        
                    </div>
                </div>
            </div><!--tweet-show-popup-footer-input-wrap end-->
            <?php } ?>
        <div class="tweet-show-popup-comment-wrap">
            <div id="comments">
                <?php 
                    foreach ($comments as $comment ) {
                        echo '<div class="tweet-show-popup-comment-box">
                                <div class="tweet-show-popup-comment-inner">
                                    <div class="tweet-show-popup-comment-head">
                                        <div class="tweet-show-popup-comment-head-left">
                                            <div class="tweet-show-popup-comment-img">
                                                <img src="'.BASE_URL.$comment->profileimage'">
                                            </div>
                                        </div>
                                        <div class="tweet-show-popup-comment-head-right">
                                            <div class="tweet-show-popup-comment-name-box">
                                                <div class="tweet-show-popup-comment-name-box-name"> 
                                                    <a href="'.BASE_URL.$comment->username'">'.$comment->screenname.'</a>
                                                </div>
                                                <div class="tweet-show-popup-comment-name-box-tname">
                                                    <a href="'.BASE_URL.$comment->username'">@'.$comment->username.' - '.$comment->commentat.'</a>
                                                </div>
                                            </div>
                                            <div class="tweet-show-popup-comment-right-tweet">
                                                    <p><a href="'.BASE_URL.$tweet->username'">@'.$tweet->username.'</a> '.$comment->comment.'</p>
                                            </div>
                                            <div class="tweet-show-popup-footer-menu">
                                                <ul>
                                                    <li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
                                                    <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
                                                    '.(($comment->commentby === $user_id) ? '
                                                    <li>
                                                    <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                    <ul> 
                                                    <li><label class="deleteComment" data-tweet="'.$tweet->$tweetid.'" data-comment="'.$comment->commentid.'">Delete Tweet</label></li>
                                                    </ul>
                                                    </li>' : '').'
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--TWEET SHOW POPUP COMMENT inner END-->
                             </div>
                        ';
                    }
                ?>
            </div>

        </div>
        <!--tweet-show-popup-box ends-->
        </div>
    </div>

    
    <?php

    }
?>
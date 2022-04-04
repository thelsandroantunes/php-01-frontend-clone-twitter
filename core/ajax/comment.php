<?php 
    include '../init.php';
    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $comment = $getFromU->checkInput($_POST['comment']);
        $user_id = $_SESSION['user_id'];
        $tweetid = $_POST['tweet_id'];

        if (!empty($comment)) {
            $getFromU->create('comments', array('comment' => $comment, 'commenton' => $tweetid, 'commentby' => $user_id, 'commentat' => date('Y-m-d H:i:s')));
            $comments = $getFromT->comments($tweetid);
            $tweet    = $getFromT->getPopupTweet($tweetid);

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
        }

    }
?>
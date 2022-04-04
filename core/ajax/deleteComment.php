<?php

	include '../init.php';

	if (isset($_POST['deleteComment']) && !empty($_POST['deleteComment'])) {
		$user_id 	= $_SESSION['user_id'];
		$commentid 	= $_POST['deleteComment'];
		$getFromU->delete('commnets', array('commentid' => $commentid, 'commentby' => $user_id ));
	}
?>
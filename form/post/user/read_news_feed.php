<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();
	require '../../../mysql/query.php';

	if (!is_numeric($_POST['news_id']))
		die;

	$news_id = $_POST['news_id'];

	if (sqlAction("UPDATE users_news_feed SET have_read = 1 WHERE id = {$news_id} AND user_id = {$_SESSION['me']['id']};")) {
		echo 'have_read';
		die;
	}
}

?>
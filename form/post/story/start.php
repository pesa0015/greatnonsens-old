<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../../mysql/query.php';
	if (!is_numeric($_SESSION['me']['id']) && !is_numeric($_POST['story']))
		die;
	$story = $_POST['story'];
	$startedByMe = sqlSelect("SELECT user_id, COUNT(user_id) AS num_of_writers FROM story_writers WHERE story_id = {$story} ORDER BY id LIMIT 1;");
	if ($startedByMe[0]['user_id'] != $_SESSION['me']['id'] && $startedByMe[0]['num_of_writers'] > 2)
		die;
	if (sqlAction("UPDATE story SET status = 1 WHERE story_id = {$story};")) {
		$story_writers = sqlSelect("SELECT user_id FROM `story_writers` WHERE story_id = {$story} AND user_id != {$_SESSION['me']['id']};");
		if ($story_writers) {
			$news_feed = "INSERT INTO users_news_feed (user_id, type_id, story_id, group_id, writer_id, have_read, date) VALUES";
			foreach($story_writers as $writer) {
				$news_feed .= " ({$writer['user_id']}, 2, {$story}, null, null, 0, now()), ";
			}
			$news_feed = rtrim($news_feed, ', ');
			$news_feed .= ';';
			if (sqlAction($news_feed)) {
				echo json_encode(array('success' => true, 'story_id' => $story));
				die;
			}
		}
	}
}
	
?>
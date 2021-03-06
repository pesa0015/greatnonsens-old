<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (!is_numeric($_SESSION['me']['id']) && !is_numeric($_POST['story']))
		die;
	require '../../../mysql/query.php';
	require '../../../lib/Pusher/config.php';
	
	$story = $_POST['story'];
	$startedByMe = sqlSelect("SELECT user_id, COUNT(user_id) AS num_of_writers FROM story_writers WHERE story_id = {$story} ORDER BY id LIMIT 1;");
	if ($startedByMe[0]['user_id'] != $_SESSION['me']['id'] && $startedByMe[0]['num_of_writers'] > 2)
		die;
	if (sqlAction("UPDATE story SET status = 1 WHERE story_id = {$story};")) {
		$story_writers = sqlSelect("SELECT user_id FROM `story_writers` WHERE story_id = {$story} AND user_id != {$_SESSION['me']['id']};");
		if ($story_writers) {
			$news_feed = "INSERT INTO users_news_feed (user_id, type_id, story_id, group_id, writer_id, have_read, date) VALUES";
			$clients = array();
			foreach($story_writers as $writer) {
				$news_feed .= " ({$writer['user_id']}, 2, {$story}, null, null, 0, now()), ";
				array_push($clients, 'private-' . $writer['user_id']);
			}
			$news_feed = rtrim($news_feed, ', ');
			$news_feed .= ';';
			if (sqlAction($news_feed)) {
				$pusher->trigger('main_channel', 'story_started', json_encode(array('story_id' => $story)));
				$pusher->trigger($clients, 'news', json_encode(array('type' => 'story_began', 'value' => $story)));
				echo json_encode(array('success' => true, 'story_id' => $story));
				die;
			}
		}
	}
}
	
?>
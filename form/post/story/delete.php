<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (!is_numeric($_SESSION['me']['id']) && is_numeric($_POST['story']))
		die;

	require '../../../mysql/query.php';
	require '../../../lib/Pusher/config.php';
		
	$story = $_POST['story'];

	$startedByMe = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} ORDER BY id LIMIT 1;");
	if ($startedByMe[0]['user_id'] != $_SESSION['me']['id'])
		die;
	$writers = sqlSelect("SELECT user_id FROM `story_writers` WHERE story_id = {$story} AND user_id != {$_SESSION['me']['id']};");
	if (sqlAction("DELETE FROM story_writers WHERE story_id = {$story};") && sqlAction("DELETE FROM row WHERE story_id = {$story};")) {
		if (sqlAction("DELETE FROM story WHERE story_id = {$story};")) {
			$clients = array();
			foreach($writers as $writer) {
				array_push($clients, 'private-' . $writer['user_id']);
			}
			$pusher->trigger($clients, 'news', json_encode(array('type' => 'story_deleted', 'story_id' => $story, 'writer' => $_SESSION['me'])));
			$pusher->trigger('main_channel', 'story_deleted', json_encode(array('story_id' => $story)));
			echo json_encode(array('success' => true, 'writers' => $writers));
			die;
		}
	}
}

?>
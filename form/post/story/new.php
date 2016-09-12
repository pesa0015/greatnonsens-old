<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../../mysql/query.php';
	require '../../../lang/config.php';
	
	$num_of_errors = 0;

	$title = sqlEscape($_POST['title']);
	$text = sqlEscape($_POST['text']);
	$rounds = sqlEscape($_POST['rounds']);
	$current_round = 2;
	$nonsensmode = sqlEscape($_POST['nonsensmode']);
	$max_writers = sqlEscape($_POST['num_of_writers']);
	$public = sqlEscape($_POST['public']);
		
	$story = "INSERT INTO story (title, rounds, current_round, max_writers, nonsens_mode, join_public, with_group, status, started_by_user, views) VALUES ('{$title}', {$rounds}, {$current_round}, {$max_writers}, {$nonsensmode}, {$public}, null, 0, {$_SESSION['me']['id']}, 0);";

	$story = sqlAction($story, $getLastId = true);

	if ($story) {
		$row = "INSERT INTO row (user_id, words, story_id, date) VALUES ({$_SESSION['me']['id']}, '{$text}', {$story}, now());";
		$story_writers = "INSERT INTO story_writers (story_id, user_id, on_turn, round, date) VALUES ({$story}, {$_SESSION['me']['id']}, 0, {$current_round}, now());";

		if (sqlAction($row) && sqlAction($story_writers)) {
			$_SESSION['noty_message'] = array(
				'text' => $translate['noty_message']['new_story_created']['text'],
				'type' => $translate['noty_message']['new_story_created']['type'],
				'dismissQueue' => $translate['noty_message']['new_story_created']['dismissQueue'],
				'layout' => $translate['noty_message']['new_story_created']['layout'],
				'theme' => $translate['noty_message']['new_story_created']['theme'],
				'timeout' => $translate['noty_message']['new_story_created']['timeout']
			);
			echo json_encode(array('story_id' => $story, 'me' => $_SESSION['me']['id']));
			die;
		}
	}
}
	
?>
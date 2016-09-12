<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['group_id']) && is_numeric($_POST['group_id']))
		$groupId = $_POST['group_id'];
	else die;
	session_start();
	require '../../../mysql/query.php';
	require '../../../lang/config.php';
	
	$num_of_errors = 0;

	$title = sqlEscape($_POST['title']);
	$text = sqlEscape($_POST['text']);
	$rounds = sqlEscape($_POST['rounds']);
	$current_round = 1;
	$max_writers = 'null';
	$nonsensmode = 1;
	$public = 'null';
	$with_group = $groupId;

	$story = sqlAction("INSERT INTO story (title, rounds, current_round, max_writers, nonsens_mode, join_public, with_group, status, started_by_user, views) VALUES ('{$title}', {$rounds}, {$current_round}, {$max_writers}, {$nonsensmode}, {$public}, {$with_group}, 1, {$_SESSION['me']['id']}, 0);", $getLastId = true);

	if ($story) {
		if (sqlAction("INSERT INTO row (user_id, words, story_id, date) VALUES ({$_SESSION['me']['id']}, '{$text}', {$story}, now());")) {
			$story_writers = "INSERT INTO story_writers (story_id, user_id, on_turn, round, date) VALUES ({$story}, {$_SESSION['me']['id']}, 0, 2, now()), ";
			$writers = sqlSelect("SELECT user_id FROM group_members WHERE group_id = {$groupId} AND user_id != {$_SESSION['me']['id']};");
			$i = 0;
			foreach($writers as $writer) {
				if ($i == 0)
					$on_turn = 1;
				else
					$on_turn = 0;
				$story_writers .= "({$story}, {$writer['user_id']}, {$on_turn}, {$current_round}, now()), ";
				$i++;
			}
			$story_writers = rtrim($story_writers, ', ');
			$story_writers .= ';';

			if (sqlAction($story_writers)) {
				$_SESSION['noty_message'] = array(
					'text' => $translate['noty_message']['new_story_created']['text'],
					'type' => $translate['noty_message']['new_story_created']['type'],
					'dismissQueue' => $translate['noty_message']['new_story_created']['dismissQueue'],
					'layout' => $translate['noty_message']['new_story_created']['layout'],
					'theme' => $translate['noty_message']['new_story_created']['theme'],
					'timeout' => $translate['noty_message']['new_story_created']['timeout']
				);
				header("Location: ../../../write?story={$story}");
			}
		}
	}
}
	
?>
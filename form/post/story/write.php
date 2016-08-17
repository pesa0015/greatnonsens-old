<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$words = sqlEscape($_POST['words']);

	if (strlen($words) >= 1 && strlen($words) <= 50 && is_numeric($_POST['story'])) {
		// Check if my turn
		$my_turn = sqlSelect("SELECT id, on_turn, round, story.rounds FROM story_writers INNER JOIN story ON story_writers.story_id = story.story_id WHERE story_id = {$_POST['story']} AND user_id = {$_SESSION['me']['id']};");
		if ($my_turn[0]['on_turn'] != 1) {
			die;
		}
		$insertWords = "INSERT INTO row (user_id, words, story_id, date) VALUES ({$_SESSION['me']['id']}, '{$words}', {$_POST['story']}, now());";
		$finishRound = "UPDATE `story_writers` SET `on_turn` = 0, round = round + 1, `date` = now() WHERE story_id = {$_POST['story']} AND user_id = {$_SESSION['me']['id']};";

		// Check if story is finished
		$rounds_left = $my_turn[0]['rounds'] - $my_turn[0]['round'] - 1;
		if ($rounds_left == 0) {
			$finishStory = "UPDATE story SET status = 2 WHERE story_id = {$_POST['story']};";
			if (sqlAction($insertWords) && sqlAction($finishRound) && sqlAction($finishStory)) {
				echo 'story is finished';
				die;
			}
		}
		// Check if next round
		$next_round = sqlSelect("SELECT id FROM `story_writers` WHERE story_id = {$_POST['story']} AND on_turn = 0 AND `id` IN (SELECT SUM(id + 1) FROM (SELECT id FROM `story_writers` WHERE story_id = {$_POST['story']} AND on_turn = 1) AS next);");
		if ($next_round) {
			$updateOnTurn = "UPDATE `story_writers` SET `on_turn` = 1, `date` = now() WHERE story_id = {$_POST['story']} ORDER BY id LIMIT 1;";
		}
		else {
			$updateOnTurn = "UPDATE story_writers SET on_turn = 1, date = now() WHERE story_id = {$_POST['story']} AND id = {$my_turn[0]['id']}+1;";
		}

		if (sqlAction($insertWords) && sqlAction($finishRound) && sqlAction($updateOnTurn)) {
			echo 'words sent';
			die;
		}
	}
}
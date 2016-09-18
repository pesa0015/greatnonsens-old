<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../../mysql/query.php';
	require '../../../lib/Pusher/config.php';

	$words = sqlEscape($_POST['words']);
	$story = $_POST['story'];

	if (strlen($words) >= 1 && strlen($words) <= 50 && is_numeric($story)) {
		// Check if my turn
		$my_turn = sqlSelect("SELECT id, on_turn, round, story.rounds FROM story_writers INNER JOIN story ON story_writers.story_id = story.story_id WHERE story_writers.story_id = {$story} AND user_id = {$_SESSION['me']['id']};");
		if ($my_turn[0]['on_turn'] != 1) {
			die;
		}
		$insertWords = "INSERT INTO row (user_id, words, story_id, date) VALUES ({$_SESSION['me']['id']}, '{$words}', {$story}, now());";
		$finishMyTurn = "UPDATE `story_writers` SET `on_turn` = 0, round = round + 1, `date` = now() WHERE story_id = {$story} AND user_id = {$_SESSION['me']['id']};";
		$ok = '';
		if (sqlAction($insertWords) && sqlAction($finishMyTurn))
			$ok = true;
		else die;

		// $round = sqlSelect("SELECT MIN(round) AS current, rounds AS end FROM story_writers INNER JOIN story ON story_writers.story_id = story.story_id WHERE story_writers.story_id = {$story};");
		$round = sqlSelect("SELECT round AS current, rounds AS end FROM story_writers INNER JOIN story ON story_writers.story_id = story.story_id WHERE story_writers.story_id = {$story} ORDER BY story_writers.id DESC LIMIT 1;");
		// Check if story is finished
		// $rounds_left = $my_turn[0]['rounds'] - $my_turn[0]['round'] - 1;
		$rounds_left = $round[0]['end'] - $round[0]['current'];
		if ($rounds_left == -1) {
			if (sqlAction("UPDATE story SET status = 2 WHERE story_id = {$story};")) {
				$story_writers = sqlSelect("SELECT user_id FROM `story_writers` WHERE story_id = {$story} AND user_id != {$_SESSION['me']['id']};");
				if ($story_writers) {
					$news_feed = "INSERT INTO users_news_feed (user_id, type_id, story_id, group_id, writer_id, have_read, date) VALUES";
					$clients = array();
					foreach($story_writers as $writer) {
						$news_feed .= " ({$writer['user_id']}, 3, {$story}, null, null, 0, now()), ";
						array_push($clients, 'private-' . $writer['user_id']);
					}
					$news_feed = rtrim($news_feed, ', ');
					$news_feed .= ';';
					if (sqlAction($news_feed)) {
						$pusher->trigger($clients, 'news', json_encode(array('type' => 'story_finished', 'value' => $story)));
						echo json_encode(array('success' => true, 'status' => 'story is finished', 'story' => $story));
						die;
					}
				}
			}
		}
		// Check if next round
		// $next_round = sqlSelect("SELECT id FROM `story_writers` WHERE story_id = {$story} AND on_turn = 0 AND `id` IN (SELECT SUM(id + 1) FROM (SELECT id FROM `story_writers` WHERE story_id = {$story} AND on_turn = 1) AS next);");
		$nextId = $my_turn[0]['id']+1;
		$next_round = sqlSelect("SELECT id FROM `story_writers` WHERE story_id = {$story} AND on_turn = 0 AND `id` = {$nextId};");
		$updateOnTurn = '';
		if (!$next_round) {
			$updateOnTurn = "UPDATE `story_writers` SET `on_turn` = 1, `date` = now() WHERE story_id = {$story} ORDER BY id LIMIT 1;";
		}
		else {
			// $updateOnTurn = "UPDATE story_writers SET on_turn = 1, date = now() WHERE story_id = {$_POST['story']} AND id = {$my_turn[0]['id']}+1 ORDER BY id DESC;";
			$updateOnTurn = "UPDATE story_writers SET on_turn = 1, date = now() WHERE story_id = {$story} AND id = {$my_turn[0]['id']}+1;";
		}

		if (sqlAction($updateOnTurn)) {
			$on_turn = sqlSelect("SELECT users.user_id, username, type FROM `users` INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_id = {$story} AND on_turn = 1;");
			if (sqlAction("INSERT INTO users_news_feed (user_id, type_id, story_id, group_id, writer_id, have_read, date) VALUES ({$on_turn[0]['user_id']}, 1, {$story}, null, null, 0, now());")) {
				$story_writers = sqlSelect("SELECT user_id FROM `story_writers` WHERE story_id = {$story} AND user_id != {$_SESSION['me']['id']} AND on_turn = 0;");
				$clients = array();
				foreach($story_writers as $writer) {
					if ($writer['user_id'] != $on_turn[0]['user_id'])
						array_push($clients, 'private-' . $writer['user_id']);
				}
				$pusher->trigger('private-' . $on_turn[0]['user_id'], 'news', json_encode(array('type' => 'my_turn', 'value' => array('story_id' => $story, 'previous_writer' => $_SESSION['me'], 'words' => $words))));
				$pusher->trigger($clients, 'news', json_encode(array('type' => 'next_writer', 'value' => array('story_id' => $story, 'next_writer' => $on_turn))));
				echo json_encode(array('success' => true, 'on_turn' => $on_turn, 'story' => $story));
				die;
			}
		}
	}
}

?>
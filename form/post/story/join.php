<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['story']) && is_numeric($_POST['story'])) {

		session_start();

		require '../../../mysql/query.php';
		$story = $_POST['story'];

		$me = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} and user_id = {$_SESSION['me']['id']};");
		$writers = sqlSelect("SELECT max_writers, COUNT(story_writers.user_id) AS num_of_writers, status FROM story INNER JOIN story_writers ON story.story_id = story_writers.story_id WHERE story.story_id = {$story};");	

		if (empty($me) && $writers[0]['status'] == 0 && $writers[0]['max_writers'] > $writers[0]['num_of_writers']) {
			$joinStory = null;
			if ($writers[0]['num_of_writers'] == 1) {
				// $on_turn = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} AND on_turn = 1;");
				$joinStory = "INSERT INTO story_writers (story_id, user_id, on_turn, round, date) VALUES ({$story}, {$_SESSION['me']['id']}, 1, 1, now());";
			}
			else {
				$joinStory = "INSERT INTO story_writers (story_id, user_id, on_turn, round, date) VALUES ({$story}, {$_SESSION['me']['id']}, 0, 1, now());";
			}
			if (sqlAction($joinStory)) {
				$num_of_writers = $writers[0]['num_of_writers']+1;
				if ($writers[0]['max_writers'] == $num_of_writers) {
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
								echo 2;
								die;
							}
						}
					}
				}
				else
					echo 1;
				die;
			}
		}
	}
}

?>
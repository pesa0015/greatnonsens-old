<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		$story = $_GET['story'];
		$info = sqlSelect("SELECT COUNT(story_writers.user_id) AS num_of_writers, started_by_user FROM story_writers INNER JOIN story ON story_writers.story_id = story.story_id WHERE story_writers.story_id = {$story};");
		if ($info[0]['num_of_writers'] > 2 && $info[0]['started_by_user'] == $_SESSION['me']['id']) {
			if (sqlAction("UPDATE story SET status = 1 WHERE story_id = {$story};")) {
				echo 1;
				die;
			}
		}
	}
}

?>
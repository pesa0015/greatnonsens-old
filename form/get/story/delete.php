<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		require '../../../lang/config.php';

		$story = $_GET['story'];

		if (sqlAction("DELETE FROM story_writers WHERE story_id = {$story};") && sqlAction("DELETE FROM row WHERE story_id = {$story};")) {
			if (sqlAction("DELETE FROM story WHERE story_id = {$story};")) {
				require '../../../lib/Firebase/url.php';
				getFirebase($require = true);

				$firebase = new Firebase\FirebaseLib($url, $token);

				$firebase->delete("stories/not_ready/{$story}");

				header("Location: ../../../");
			}
		}
	}
}

?>
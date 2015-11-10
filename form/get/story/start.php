<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		require '../../../lang/config.php';

		$story = $_GET['story'];

		$writer = sqlSelect("SELECT guest_id FROM story_writers WHERE story_id = {$story} and guest_id = {$_SESSION['guest_id']};");
		if (empty($writer[0]['guest_id'])) {
			if (sqlAction("INSERT INTO story_writers (story_id, user_id, guest_id, on_turn, round, date) VALUES ({$story}, null, {$_SESSION['guest_id']}, 0, 1, now());")) {
				require '../../../lib/Firebase/url.php';
				getFirebase($require = true);

				$firebase = new Firebase\FirebaseLib($url, $token);

				$increment_writers = $firebase->get("stories/not_ready/{$story}/writers") + 1;

				$firebaseArray = array('writers' => $increment_writers);

				$firebase->update("stories/not_ready/{$story}/", $firebaseArray);

				header("Location: ../../../write?not_ready&story={$story}");
			}
		}
		else {
			header("Location: ../../../write?not_ready&story={$story}");
		}
	}
}

?>
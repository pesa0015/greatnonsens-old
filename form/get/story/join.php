<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		require '../../../lang/config.php';

		$story = $_GET['story'];

		// $user_id = (isset($_SESSION['user'])) ? $_SESSION['user']['id'] : 'null';
		// $guest_id = (isset($_SESSION['guest_id']) && is_numeric($_SESSION['guest_id'])) ? $_SESSION['guest_id'] : 'null';

		// $writer = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} and user_id = {$user_id} OR guest_id = {$guest_id};");

		$writer = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} and user_id = {$_SESSION['me']['id']};");

		if (empty($writer)) {
			require '../../../lib/Firebase/url.php';
			getFirebase($require = true);

			$firebase = new Firebase\FirebaseLib($url, $token);

			$increment_writers = $firebase->get("stories/not_ready/{$story}/writers") + 1;

			$on_turn = 0;
			if ($increment_writers == 2)
				$on_turn = 1;

			if (sqlAction("INSERT INTO story_writers (story_id, user_id, on_turn, round, date) VALUES ({$story}, {$_SESSION['me']['id']}, {$on_turn}, 1, now());")) {

				// if ($on_turn == 1 && isset($_SESSION['user']))
				// 	$firebaseArray = array('writers' => $increment_writers, 'on_turn' => array('user' => array('user_id' => $_SESSION['user']['id'], 'user_name' => "{$_SESSION['user']['name']}"), 'guest' => false));
				// if ($on_turn == 1 && isset($_SESSION['guest_id']) && is_numeric($_SESSION['guest_id']))
				// 	$firebaseArray = array('writers' => $increment_writers, 'on_turn' => array('user' => false, 'guest' => $_SESSION['guest_id']));
				// else if ($on_turn == 0)
				// 	$firebaseArray = array('writers' => $increment_writers, 'on_turn' => array('user' => false, 'guest' => false));

				if ($on_turn == 1)
					$firebaseArray = array('writers' => $increment_writers, 'on_turn' => array('user_id' => $_SESSION['me']['id'], 'user_name' => "{$_SESSION['me']['name']}"));
				else
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
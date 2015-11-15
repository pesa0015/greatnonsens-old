<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		require '../../../lang/config.php';

		$story = $_GET['story'];

		// $user_id = '';
		// $guest_id = '';
		// if (isset($_SESSION['user']))
		// 	$user_id = $_SESSION['user']['id'];
		// if (isset($_SESSION['guest_id']) && is_numeric($_SESSION['guest_id']))
		// 	$guest_id = $_SESSION['guest_id'];

		// $me = ($user_id != '') ? $user_id : $guest_id;

		if (sqlAction("DELETE FROM story_writers WHERE story_id = {$story} AND user_id = {$_SESSION['me']['id']};")) {
			require '../../../lib/Firebase/url.php';
			getFirebase($require = true);

			$firebase = new Firebase\FirebaseLib($url, $token);

			// $decrease_writers = $firebase->get("stories/not_ready/{$story}/writers") - 1;

			$data = json_decode($firebase->get("stories/not_ready/{$story}/"));

			$decrease_writers = $data->writers - 1;

			if (is_numeric($data->on_turn) && $data->on_turn->user_id == $_SESSION['me']['id'])
				$firebaseArray = array('writers' => $decrease_writers, 'on_turn' => false);
			else
				$firebaseArray = array('writers' => $decrease_writers);

			$firebase->update("stories/not_ready/{$story}/", $firebaseArray);

			header("Location: ../../../");
		}
	}
}

?>
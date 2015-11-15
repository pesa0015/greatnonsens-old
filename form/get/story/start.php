<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		require '../../../lang/config.php';

		$story = $_GET['story'];

		require '../../../lib/Firebase/url.php';
		getFirebase($require = true);

		$firebase = new Firebase\FirebaseLib($url, $token);

		$data = json_decode($firebase->get("stories/not_ready/{$story}/"));

		$firebaseArray = array('current_round' => 1, 'latest_words' => $data->opening_words, 'on_turn' => $data->on_turn, 'title' => $data->title, 'total_rounds' => $data->total_rounds);

		$firebase->delete("stories/not_ready/{$story}/");

		$firebase->set("stories/started/{$story}/", $firebaseArray);

		header("Location: ../../../write?story={$story}");
	}
}

?>
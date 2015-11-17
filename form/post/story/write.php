<?php

// require '../../../lib/Firebase/url.php';
// getFirebase($require = true);

// $firebase = new Firebase\FirebaseLib($url, $token);

// $started = json_decode($firebase->get("stories/started/58/"));

// $firebaseArray = array('latest_words' => 'asdasda');

// $firebase->update("stories/started/58/", $firebaseArray);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$words = sqlEscape($_POST['words']);

	if (strlen($words) >= 1 && strlen($words) <= 50) {
		// $guest_id = (!$_SESSION['guest_id']) ? $guest_id = null : $_SESSION['guest_id'];
		// $user_id = (!isset($_SESSION['user'])) ? $user_id = null : $_SESSION['user']['id'];
		$insert1 = "INSERT INTO row (user_id, words, story_id, date) VALUES ({$_SESSION['me']['id']}, '{$words}', {$_POST['story']}, now());";
		// if (!$user_id) $insert1 .= "(null, {$guest_id}, ";
		// if (!$guest_id) $insert1 .= "({$user_id}, null, ";
		// $insert1 .= "'{$words}', {$_POST['story']}, now());";
		$insert2 = "UPDATE `story_writers` SET `on_turn` = 1, `date` = now() WHERE `id` IN (SELECT MIN(id) FROM (SELECT * FROM `story_writers`) AS id WHERE story_id = {$_POST['story']} AND on_turn = 0 ORDER BY date);";
		$insert3 = "UPDATE `story_writers` SET `on_turn` = 0, round = round + 1, `date` = now() WHERE story_id = {$_POST['story']} AND user_id = {$_SESSION['me']['id']};";
		// if (!$user_id) $insert3 .= "user_id IS NULL AND guest_id = {$guest_id};";
		// if (!$guest_id) $insert3 .= "user_id = {$_SESSION['user']['id']} AND guest_id IS NULL;";

		// echo $insert; die;

		if (sqlAction($insert1) && sqlAction($insert2) && sqlAction($insert3)) {
			$round = sqlSelect("SELECT story.rounds, MIN(story_writers.round) AS current_round FROM story INNER JOIN `story_writers` ON story.story_id = story_writers.story_id WHERE story_writers.story_id = {$_POST['story']};");

			if ($round) {
				require '../../../lib/Firebase/url.php';
				getFirebase($require = true);

				$firebase = new Firebase\FirebaseLib($url, $token);

				if ($round[0]['rounds'] == $round[0]['current_round']) {
					if (sqlAction("UPDATE story SET status = 2 WHERE story_id = {$_POST['story']};")) {

						$firebaseArray = array(
						'likes' => 0,
						'dislikes' => 0,
						'views' => 0
						);

						$firebase->set("stories/finished/{$_POST['story']}/", $firebaseArray);
						header("Location: ../../../write?story={$_POST['story']}");
					}
				}
				else {
					$next = sqlSelect("SELECT users.user_id, users.username FROM users INNER JOIN `story_writers` ON users.user_id = story_writers.user_id WHERE story_writers.story_id = {$_POST['story']} AND on_turn = 1;");
// 					$next =  sqlSelect("SELECT 
// CASE users.user_id WHEN NULL THEN story_writers.guest_id ELSE users.user_id END AS user_id, 
// CASE users.username WHEN NULL THEN story_writers.guest_id ELSE users.username END AS username, 
// CASE story_writers.guest_id WHEN NULL THEN users.user_id ELSE story_writers.guest_id END AS guest_id,
// CASE story_writers.guest_id WHEN NULL THEN users.username ELSE story_writers.guest_id END AS guest_name
// FROM users INNER JOIN `story_writers` ON users.user_id = story_writers.user_id WHERE story_writers.story_id = 58 AND on_turn = 1");
// 					echo "SELECT users.user_id, users.username, story_writers.guest_id FROM users INNER JOIN `story_writers` ON users.user_id = story_writers.user_id WHERE story_writers.story_id = {$_POST['story']} AND on_turn = 1;<br />";
// 					echo '<pre>';
// 					print_r($next);
// 					echo '</pre>';
// 					die;
					// if (empty($next)) {
					// 	$firebaseArray = array(
					// 		'current_round' => $round[0]['current_round'],
					// 		'latest_words' => "{$words}",
					// 		'on_turn' => array('guest' => $next[0]['guest_id'], 'user' => false)
					// 	);
					// }
					// else {
					// 	$firebaseArray = array(
					// 		'current_round' => $round[0]['current_round'],
					// 		'latest_words' => "{$words}",
					// 		'on_turn' => array('guest' => false, 'user' => array('user_id' => $next[0]['user_id'], 'user_name' => "{$next[0]['username']}"))
					// 	);
					// }
					if (!empty($next)) {
						$firebaseArray = array(
							'current_round' => (int) $round[0]['current_round'],
							'latest_words' => "{$words}",
							'on_turn' => array('user_id' => (int) $next[0]['user_id'], 'user_name' => "{$next[0]['username']}")
						);
						$firebase->update("stories/started/{$_POST['story']}/", $firebaseArray);
						header("Location: ../../../write?story={$_POST['story']}");
					}
				}
			}
		}
	}
}
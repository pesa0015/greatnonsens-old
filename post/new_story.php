<?php

// if ($_SERVER['REQUEST_METHOD'] != 'POST')
// 	header('Location: ../');

session_start();

require '../mysql/query.php';
require '../lang/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_COOKIE['story_nr_5'])) {
		$_SESSION['noty_message'] = array(
			'text' => $translate['noty_message']['already_3_stories']['text'],
			'type' => $translate['noty_message']['already_3_stories']['type'],
			'dismissQueue' => $translate['noty_message']['already_3_stories']['dismissQueue'],
			'layout' => $translate['noty_message']['already_3_stories']['layout'],
			'theme' => $translate['noty_message']['already_3_stories']['theme'],
			'timeout' => $translate['noty_message']['already_3_stories']['timeout']
			);
		header('Location: ../');
		die;
	}

	$num_of_errors = 0;

	if (isset($_POST['story_title']) && strlen($_POST['story_title']) == 0) {
		$num_of_errors++;
		$_SESSION['errors']['story_title'] = true;
	}

	if (isset($_POST['text']) && strlen($_POST['text']) == 0) {
		$num_of_errors++;
		$_SESSION['errors']['text'] = true;
	}

	if ($num_of_errors == 0) {
		$title = sqlEscape($_POST['story_title']);
		$text = sqlEscape($_POST['text']);
		$story_length = 'null';
		$rounds = 'null';
		$total_rows = 'null';
		$current_round = 'null';
		$user_id = 'null';
		$guest_id = 'null';
		if ($_POST['flexible'] == 0 && is_numeric($_POST['rounds']))
			$rounds = $_POST['rounds'];
		if ($_POST['flexible'] == 0 && is_numeric($_POST['more_rounds']))
			$rounds = $_POST['more_rounds'];
		if ($_POST['flexible'] == 1 && is_numeric($_POST['story_length']))
			$story_length = $_POST['story_length'];
		if ($_POST['flexible'] == 1 && is_numeric($_POST['longer_story']))
			$story_length = $_POST['longer_story'];
		if ($rounds != 'null')
			$current_round = 1;
		if ($story_length != 'null')
			$total_rows = 1;
		if (isset($_SESSION['user_id']))
			$user_id = $_SESSION['user_id'];
		if (isset($_SESSION['guest_id']))
			$guest_id = $_SESSION['guest_id'];
		if (!empty($story_length) && $_POST['nonsensmode'] == 0 || $_POST['nonsensmode'] == 1) {
			$story = "INSERT INTO story";
			$story .= " (title, max_rows, total_rows, rounds, current_round, close_at_midnight, max_writers, admin, flexible, nonsens_mode, with_group, published, views)";
			$story .= " VALUES ('{$title}', '{$story_length}', '{$total_rows}', '{$rounds}', '{$current_round}', 1, {$_POST['max_writers']}, null, {$_POST['flexible']}, {$_POST['nonsensmode']}, null, 0, 0);";
			// echo $story;
			if (sqlAction($story)) {
				$story_id = sqlSelect("SELECT MAX(story_id) AS id FROM story");
				$row = "INSERT INTO row";
				$row .= " (user_id, guest_id, words, story_id, date)";
				$row .= " VALUES ({$user_id}, {$guest_id}, '{$_POST['text']}', {$story_id[0]['id']}, now());";
				// echo $row;
				$story_writers = "INSERT INTO story_writers";
				$story_writers .= " (story_id, user_id, guest_id, on_turn, round, is_typing, date)";
				$story_writers .= " VALUES ({$story_id[0]['id']}, {$user_id}, {$guest_id}, 0, {$current_round}, 0, now());";

				if (sqlAction($row) && sqlAction($story_writers)) {
					if (!isset($_COOKIE['story']))
						setcookie('story', 1, time() + strtotime('today 23:59'));
					else if (isset($_COOKIE['story'])) {
						switch ($_COOKIE['story']) {
							case 1:
								setcookie('story', 2, time() + strtotime('today 23:59'));
								break;
							case 2:
								setcookie('story', 3, time() + strtotime('today 23:59'));
								break;
							default:
								break;
						}
					}
					// if (!isset($_COOKIE['story_nr_1']))
					// 	setcookie('story_nr_1', '1', time() + strtotime('today 23:59'));
					// if (!isset($_COOKIE['story_nr_2']) && isset($_COOKIE['story_nr_1']))
					// 	setcookie('story_nr_2', '1', time() + strtotime('today 23:59'));
					// if (!isset($_COOKIE['story_nr_3']) && isset($_COOKIE['story_nr_2']))
					// 	setcookie('story_nr_3', '1', time() + strtotime('today 23:59'));
					$_SESSION['noty_message'] = array(
						'text' => $translate['noty_message']['new_story_created']['text'],
						'type' => $translate['noty_message']['new_story_created']['type'],
						'dismissQueue' => $translate['noty_message']['new_story_created']['dismissQueue'],
						'layout' => $translate['noty_message']['new_story_created']['layout'],
						'theme' => $translate['noty_message']['new_story_created']['theme'],
						'timeout' => $translate['noty_message']['new_story_created']['timeout']
						);
					header('Location: ../write?story={$story_id[0]['id']}');
				}
			}
			// if (sqlAction("INSERT INTO story (title, max_rows, total_rows, rounds, current_round, max_writers, admin, flexible, nonsens_mode, with_group, published, views) VALUES ('{$title}', '{$story_length}', '{$total_rows}', '{$rounds}', '{$current_round}', null, '{$admin}', $flexible, $nonsens_mode, null, 0, 0);"))
			// echo $story;
		}
	}
	else {
		$_SESSION['noty_message'] = array(
			'text' => $translate['noty_message']['form_error']['text'],
			'type' => $translate['noty_message']['form_error']['type'],
			'dismissQueue' => $translate['noty_message']['form_error']['dismissQueue'],
			'layout' => $translate['noty_message']['form_error']['layout'],
			'theme' => $translate['noty_message']['form_error']['theme'],
			'timeout' => $translate['noty_message']['form_error']['timeout']
			);
		header('Location: ../?view=new_story');
	}

}

?>
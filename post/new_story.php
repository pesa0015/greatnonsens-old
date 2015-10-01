<?php

session_start();

require '../lang/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_SESSION['noty_message'] = array(
		'text' => $translate['noty_message']['new_story_created']['text'],
		'type' => $translate['noty_message']['new_story_created']['type'],
		'dismissQueue' => $translate['noty_message']['new_story_created']['dismissQueue'],
		'layout' => $translate['noty_message']['new_story_created']['layout'],
		'theme' => $translate['noty_message']['new_story_created']['theme'],
		'timeout' => $translate['noty_message']['new_story_created']['timeout']
		);
	header('Location: ../write');
}

?>
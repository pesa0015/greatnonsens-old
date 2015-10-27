<?php

session_start();

if (!isset($_GET['view']) || empty($_GET['view']))
	header("Location: {$_SESSION['user']['name']}");

require 'header.php';

if (isset($_GET['view'])) {
	switch ($_GET['view']) {
		case 'friends':
			require 'views/profile/friends.php';
			$script = 'js/profile.friends.js';
			break;
		case 'change_password':
			require 'views/profile/change_password.php';
			break;
		default:
			require 'views/profile/who.php';
			$script = 'js/profile.who.js';
			break;
	}
}

require 'footer.php';

?>
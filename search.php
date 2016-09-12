<?php

session_start();

require 'layout/header.php';

if (isset($_GET['after'])) {
	switch ($_GET['after']) {
		case 'group':
			require 'views/search/group.php';
			$table = 'groups';
			break;
		case 'user':
			require 'views/search/user.php';
			$table = 'users';
			break;
	}

	if (isset($_GET['query']) && !empty($_GET['query'])) {
		require "views/search/result.php";
	}
}

require 'footer.php';

?>
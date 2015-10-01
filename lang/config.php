<?php

if (isset($_SESSION['lang'])) {
	switch ($_SESSION['lang']) {
		case 'sv':
			require 'sv.php';
			break;
		case 'en':
			require 'en.php';
			break;
		default:
			require 'en.php';
			break;
	}
}
else
	require 'en.php';

?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	header('Access-Control-Allow-Origin: *');
	echo substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
}

?>
<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
}

?>
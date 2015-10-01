<?php

require 'connect.php';

function sqlSelect($query) {
	// $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_USER);
	$stmt = $db->query($query);
	$resultArray = array();
	if ($stmt) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			$resultArray[] = $row;
	}

	return $resultArray;

	$stmt->closeCursor();
	$db = null;
}

function sqlAction($query) {
	$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_USER);
	if ($db->query($query))
		return true;
	return false;

	$stmt->closeCursor();
	$db = null;
}

?>
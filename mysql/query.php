<?php

require 'connect.php';

function sqlSelect($query) {
	// $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$stmt = $db->query($query);
	$resultArray = array();
	if ($stmt) {
		while ($row = $stmt->fetch_assoc())
			$resultArray[] = $row;
	}

	return $resultArray;

	$stmt->closeCursor();
	$db = null;
}

function sqlAction($query) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($db->query($query))
		return true;
	return false;

	$stmt->closeCursor();
	$db = null;
}

function sqlEscape($string) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$escaped_string = $db->real_escape_string($string);

	return $escaped_string;
}

?>
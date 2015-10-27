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

function sqlAction($query, $getLastId = false) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($db->query($query)) {
		if ($getLastId)
			return $db->insert_id;
		return true;
	}
	return false;

	$stmt->closeCursor();
	$db = null;
}

function sqlEscape($string) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$escaped_string = $db->real_escape_string($string);

	return $escaped_string;
}

function lastId() {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	return $db->insert_id;
}

function timeAgo($time) {
	$date = new DateTime($time);

					$today = new DateTime();
					$yesterday = new DateTime('-1day');
					$this_year = new DateTime();

					switch(TRUE) {

						case $today->format('m-d') === $date->format('m-d'):
							$day_name = 'Idag ' . $date->format('H:i') . '';
						break;

						case $yesterday->format('m-d') === $date->format('m-d'):
							$day_name = 'Igår ' . $date->format('H:i') . '';
						break;

						case $this_year->format('Y') === $date->format('Y'):
							$day_name = $date->format('m/d H:i') . '';
						break;

						default:
							$day_name = $date->format('Y-m-d H:i');
					}

					return $day_name;
}

?>
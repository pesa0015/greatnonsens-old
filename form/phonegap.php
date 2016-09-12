<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	header('Access-Control-Allow-Origin: *');

	$fields = $_POST;

	function httpPost($file, $data) {
		$baseUrl = 'http://localhost.greatnonsens.com/form/' . $file;
	    $curl = curl_init($baseUrl);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return $response;
	}
	$t = httpPost($_POST['target'], $fields);
	echo $t;

}

?>
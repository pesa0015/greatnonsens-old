<?php

require '../../../lib/Firebase/JWT.php';
require '../../../lib/Firebase/TokenException.php';
require '../../../lib/Firebase/TokenGenerator.php';

function getToken() {
	try {
	    $generator = new FireBase\Token\TokenGenerator('g9jEEntnvT5BC4Pp5HW7jCMxyUubN9R8LTMfm4HU');
	    $token = $generator
	        ->setData(array('uid' => 'exampleID'))
	        ->create();
	} catch (TokenException $e) {
	    echo "Error: ".$e->getMessage();
	}

	return $token;
}

function getFirebase($require = false) {
 	if ($require) {
 		require '../../../lib/Firebase/firebaseInterface.php';
		require '../../../lib/Firebase/firebaseStub.php';
		require '../../../lib/Firebase/firebaseLib.php';
 	}
}

function usersNewsFeed($id) {
	return "/users/{$id}/news_feed/";
}

$url = 'https://greatnonsens.firebaseio.com/';
$token = getToken();

?>
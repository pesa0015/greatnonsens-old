<?php

$languages = array(
	'en' => 'English',
	'sv' => 'Svenska'
	);

$current_lang = '';

foreach ($languages as $lang_code => $lang) {
	if ($lang_code == $_SESSION['lang']) {
		$current_lang = $lang;
		break;
	}
}

if ($current_lang == '')
	$current_lang = 'English';

?>
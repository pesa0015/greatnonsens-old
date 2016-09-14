<div id="story-id" data-story="<?=$story; ?>"></div>
<div id="content">
	<h1><?=$title[0]['title']; ?></h1>
	<div>Öppningsmening:</div>
	<div><?=$opening_words[0]['words']; ?></div>
	<hr />
	<p id="text">
		<?php foreach($words as $word): ?>
		<span><?=$word['words']; ?></span>
		<?php endforeach; ?>
	</p>
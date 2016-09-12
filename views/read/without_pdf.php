<h1><?=$title[0]['title']; ?></h1>
<a href="read/<?=$story; ?>/pdf" class="btn btn-success" target="_blank">Öppna pdf</a>
<div id="writers">
	<?php
	for ($i = 0; $i < count($writers); $i++): ?>
		<?php if ($i == count($writers)-1): ?>
		<span class="story-writer"><?=$writers[$i]['username']; ?></span>
		<?php else: ?>
		<span class="story-writer"><?=$writers[$i]['username']; ?>, </span>
		<?php endif; ?>
	<?php endfor; ?>
</div>
<hr />
<?php foreach ($words as $word): ?>
<span><?=$word['words']; ?></span>
<?php endforeach; ?>
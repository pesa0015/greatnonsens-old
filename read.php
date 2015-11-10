<?php

if (!isset($_GET['story']) || empty($_GET['story']) || !is_numeric($_GET['story']))
	header('Location: /');

$story = (int)$_GET['story'];

require 'header.php';

$title = sqlSelect("SELECT title FROM story WHERE story_id = {$story} AND status = 3;");

if ($title)
	$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story};");

?>

<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
				<?php if ($title): ?>
					<h1><?=$title[0]['title']; ?></h1>
					<?php foreach ($words as $word): ?>
					<span><?=$word['word']; ?></span>
					<?php endforeach; ?>
				<?php endif; ?>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>

<?php

require 'footer.php';

?>
<div id="content">
	<?php if (empty($writer)) { ?>
	<h1>Den här berättelsen har avbrutits.</h1>
	<?php }
	else { ?>
		<h1 id="cancelled" style="display: none;">Den här berättelsen har avbrutits.</h1>
		<div id="alright" style="display: block;">
			<h1><?=$writer[0]['max_writers']; ?> / <span id="writers"></span> författare</h1>
			<?php if (isset($started_by) && $started_by == $_SESSION['me']['id']) { ?>
			<a href="form/get/story/delete?story=<?=$story; ?>" class="btn btn-primary btn-lg" style="float: left;">Avbryt</a>
			<?php } else { ?>
			<a href="form/get/story/leave?story=<?=$story; ?>" class="btn btn-primary btn-lg">Lämna</a>
			<?php } ?>
		</div>
	<?php } ?>
</div>
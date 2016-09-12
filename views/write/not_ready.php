
<?php if (empty($writer)): ?>
	<h1>Den här berättelsen har avbrutits.</h1>
	<?php else: ?>
	<?php if ($status[0]['join_public'] == 0 && empty($me)): ?>
	<div id="join-story-with-link-modal" class="md-modal md-effect-1 md-show">
		<div class="md-content">
			<h1>Delta i storyn</h1>
			<button class="btn btn-success" onclick="joinStory(false, true);">Ja</button>
		</div>
	</div>
	<?php endif; ?>
		<div id="my-turn"></div>
		<div id="status">
		<h1 id="cancelled" style="display: none;">Den här berättelsen har avbrutits.</h1>
		<div id="alright" style="display: block;">
			<h1><?=$writer[0]['max_writers']; ?> / <span id="writers"><?=$writer[0]['num_of_writers']; ?></span> författare</h1>
			<?php if ($on_turn): ?>
				<?php if ($on_turn[0]['user_id'] == $_SESSION['me']['id']) { ?>
				<div>Jag fortsätter berättelsen.</div>
				<?php } else if ($on_turn[0]['user_id'] != $_SESSION['me']['id'] && $on_turn[0]['type'] == 1) { ?>
				<div>
					<a href=""><?=$on_turn[0]['username']; ?> fortsätter berättelsen.</a>
				</div>
				<?php } else { ?>
					<div>Gäst <?=$on_turn[0]['user_id']; ?> fortsätter berättelsen.</div>
				<?php } ?>
			<?php endif; ?>
			<?php if ($writer[0]['num_of_writers'] > 2 && $writer[0]['started_by_user'] == $_SESSION['me']['id']): ?>
			<a href="form/get/story/start?story=<?=$_GET['story']; ?>" id="begin" class="btn btn-default btn-lg" style="float: right;">Börja</a>
			<?php endif; ?>
			<?php if (isset($started_by) && $started_by == $_SESSION['me']['id']): ?>
			<a href="form/get/story/delete?story=<?=$story; ?>" class="btn btn-primary btn-lg" style="float: left;">Avbryt</a>
			<?php else: ?>
			<a href="form/get/story/leave?story=<?=$story; ?>" class="btn btn-primary btn-lg">Lämna</a>
			<?php endif; ?>
		</div>
		</div>
	<?php endif; ?>
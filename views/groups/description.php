<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
<?php

if (!isset($_GET['edit'])) {
				$group = sqlSelect("SELECT groups.description, group_members.admin FROM groups INNER JOIN group_members WHERE groups.id = {$_GET['view']} AND group_members.user_id = {$_SESSION['user']['id']} GROUP BY group_members.admin");
				if (!empty($group[0]['description']) && !empty($group[0]['admin'])): ?>
				<a href="groups?view=<?=$_GET['view']; ?>&show=description&edit" class="btn btn-primary">Redigera</a>
				<hr />
				<p><?=$group[0]['description']; ?><p>
				<?php else: ?>
					<div>Gruppen har ingen beskrivning än.</div>
					<?php if (!empty($group[0]['admin'])): ?>
					<a href="groups?view=<?=$_GET['view']; ?>&show=description&edit" class="btn btn-primary">Lägg till beskrivning</a>
				<?php 
					endif;
				endif;
			}

			if (isset($_GET['edit']) && empty($_GET['edit'])):
				$group = sqlSelect("SELECT groups.description, group_members.admin FROM groups INNER JOIN group_members WHERE groups.id = {$_GET['view']} AND group_members.user_id = {$_SESSION['user']['id']} GROUP BY group_members.admin");
				if (!empty($group[0]['admin'])): ?>
				<form action="form/post/group/edit_description" method="post">
					<input type="hidden" name="group_id" value="<?=$_GET['view']; ?>">
					<textarea name="group_description" class="form-control"><?=$group[0]['description']; ?></textarea>
					<input type="submit" class="btn btn-success" value="Spara">
				</form>
			<?php else: ?>
				<p>Du har inte behörighet att ändra gruppens beskrivning.</p>
			<?php endif;
			endif;

?>

</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
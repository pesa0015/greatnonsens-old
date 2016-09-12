<?php
			if (!$subPage) {
				// $member = sqlSelect("SELECT groups.description, group_members.admin FROM groups INNER JOIN group_members WHERE groups.id = {$groupId} GROUP BY group_members.admin;");
				if (!empty($group_info[0]['description']) && !empty($member[0]['admin'])): ?>
				<a href="groups/<?=$groupId; ?>/description/edit" class="btn btn-primary">Redigera</a>
				<hr />
				<p><?=$group_info[0]['description']; ?><p>
				<?php else: ?>
					<div>Gruppen har ingen beskrivning än.</div>
					<?php if (!empty($member[0]['admin'])): ?>
					<a href="groups/<?=$groupId; ?>/description/edit" class="btn btn-primary">Lägg till beskrivning</a>
				<?php 
					endif;
				endif;
			}

			if ($subPage === 'edit'):
				$member = sqlSelect("SELECT groups.name, groups.description, group_members.admin FROM groups INNER JOIN group_members WHERE groups.id = {$groupId} AND group_members.user_id = {$_SESSION['user']['id']} GROUP BY group_members.admin;");
				if (!empty($member[0]['admin'])): ?>
				<form action="form/post/group/edit_description" method="post">
					<input type="hidden" name="group_id" value="<?=$groupId; ?>">
					<input type="hidden" name="group_name" value="<?=$group_info[0]['name']; ?>">
					<textarea name="group_description" class="form-control"><?=$group_info[0]['description']; ?></textarea>
					<input type="submit" class="btn btn-success" value="Spara">
				</form>
			<?php else: ?>
				<p>Du har inte behörighet att ändra gruppens beskrivning.</p>
			<?php endif;
			endif;

?>
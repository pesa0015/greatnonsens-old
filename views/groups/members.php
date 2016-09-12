<?php

function isAdmin() {
	global $member;
	return (isset($member[0]['admin']) && $member[0]['admin'] == 1) ? true : false;
}

if (isAdmin()) {
	$invitedMembers = sqlSelect("SELECT users.user_id, users.username, group_members.id FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$groupId} AND group_members.user_id != {$_SESSION['user']['id']} AND group_members.status = 2;");
	$requests = sqlSelect("SELECT users.user_id, users.username, group_members.id FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$groupId} AND group_members.user_id != {$_SESSION['user']['id']} AND group_members.status = 3;");
}
$members = sqlSelect("SELECT users.user_id, users.username, group_members.id, group_members.admin FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$groupId} AND group_members.status = 1;");

// $group_info = sqlSelect("SELECT groups.name, groups.secret, groups.chat_is_public, IF (EXISTS(SELECT user_id FROM group_members WHERE group_id = {$groupId} AND user_id = {$_SESSION['user']['id']}), user_id, 0) AS user_id, group_members.status, group_members.admin FROM groups INNER JOIN group_members ON groups.id = group_members.group_id WHERE group_id = {$groupId} AND user_id = {$_SESSION['user']['id']};");

?>

		<h1>Medlemmar (<?=count($members); ?>)</h1>
		<?php if (isAdmin()): ?>
			<ul class="breadcrumb">
			  	<li><a href="groups/<?=$groupId; ?>/members">Medlemmar</a></li>
			  	<li><a href="groups/<?=$groupId; ?>/members/invited">Inbjudna <?=(count($invitedMembers) > 0) ? '(' . count($invitedMembers) . ')' : ''; ?></a></li>
			  	<li><a href="groups/<?=$groupId; ?>/members/requests">Förfrågningar <?=(count($requests) > 0) ? '(' . count($requests) . ')' : ''; ?></a></li>
			</ul>
			<?php if (!$subPage): ?>
			<div style="color:#FFFFFF;text-align:right;">Administratör</div>
			<?php endif; ?>
		<?php endif; ?>
		
				<?php if (!$subPage) { ?>
					<div class="list-group">
					<?php foreach ($members as $groupMember): ?>
						<blockquote id="block-<?=$groupMember['user_id']; ?>">
							<a href="users/<?=$groupMember['user_id']; ?>"><?=$groupMember['username']; ?></a>
							<?php if (isAdmin()): ?>
								<?php if ($groupMember['user_id'] != $_SESSION['user']['id']): ?>
								<?php /*<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/delete_member?view=<?=$_GET['view']; ?>&delete=<?=$member['id']; ?>');">Ta bort medlem</button>*/ ?>
								<span class="btn btn-danger float-right" data-member="<?=$groupMember['user_id']; ?>" onclick="removeMember(this);">Ta bort medlem</span>
								<?php endif; ?>
								<input type="checkbox" id="member-<?=$groupMember['user_id']; ?>" data-member="<?=$groupMember['user_id']; ?>" onclick="manageAdmin(this, 'remove');" <?=($groupMember['admin'] == 1) ? 'checked' : ''; ?>>
								<?php if ($groupMember['admin'] == 0): ?>
								<?php /*<span id="member-<?=$groupMember['user_id']; ?>" class="btn btn-default float-right" data-member="<?=$groupMember['user_id']; ?>" onClick="manageAdmin(this, 'remove');">Ge adminstratörs-rättigheter</span>*/ ?>
								
								<?php else: ?>
								<?php /*<button class="btn btn-default float-right" onClick="window.location.replace('form/get/group/remove_admin?view=<?=$_GET['view']; ?>&admin=<?=$member['id']; ?>');">Ta bort adminstratörs-rättigheter</button>
								<input type="checkbox" id="member-<?=$groupMember['user_id']; ?>" data-member="<?=$groupMember['user_id']; ?>" onclick="manageAdmin(this, 'remove');"><span id="member-<?=$groupMember['user_id']; ?>-text"> Ja</span>*/ ?>
								<?php endif; endif; ?>
						</blockquote>
					<?php endforeach; ?>
					</div>
				<?php }
					
				if ($subPage === 'invited') {
					if (isAdmin()) { ?>
						<div class="list-group">
						<?php foreach ($invitedMembers as $groupMember): ?>
							<blockquote><a href="users/<?=$groupMember['user_id']; ?>"><?=$groupMember['username']; ?></a><button class="btn btn-danger float-right" onClick="manageMember('decline', <?=$groupMember['user_id']; ?>, <?=$groupMember['id']; ?>, this);">Dra tillbaka inbjudan</button></blockquote>
						<?php endforeach; ?>
						</div>
						<?php }
					else { ?>
						<h3>Du är inte admin och har inte behörighet till den här sidan.</h3>
					<?php }
				}
				if ($subPage === 'requests') {
					if (isAdmin()) { ?>
						<div class="list-group">
						<?php foreach ($requests as $groupMember): ?>
							<blockquote><a href="users/<?=$groupMember['user_id']; ?>"><?=$groupMember['username']; ?></a><button class="btn btn-danger float-right" onClick="manageMember('decline', <?=$groupMember['user_id']; ?>, <?=$groupMember['id']; ?>, this);">Neka</button><button class="btn btn-success float-right" onClick="manageMember('accept', <?=$groupMember['user_id']; ?>, <?=$groupMember['id']; ?>, this);">Acceptera förfrågan</button></blockquote>
						<?php endforeach; ?>
						</div>
					<?php }
					else { ?>
						<h3>Du är inte admin och har inte behörighet till den här sidan.</h3>
					<?php }} ?>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
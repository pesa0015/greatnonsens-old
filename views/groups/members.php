<?php

$group_info = sqlSelect("SELECT groups.name, groups.secret, groups.chat_is_public, IF (EXISTS(SELECT user_id FROM group_members WHERE group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']}), user_id, 0) AS user_id, group_members.status, group_members.admin FROM groups INNER JOIN group_members ON groups.id = group_members.group_id WHERE group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']};");

?>
<section class="section" id="head">
	<div class="container">
		<h1>Medlemmar</h1>
		<?php if ($group_info[0]['admin'] == 1): ?>
			<ul class="breadcrumb">
			  	<li><a href="groups?view=<?=$_GET['view']; ?>&show=members">Medlemmar</a></li>
			  	<li><a href="groups?view=<?=$_GET['view']; ?>&show=members&invited">Inbjudna</a></li>
			  	<li><a href="groups?view=<?=$_GET['view']; ?>&show=members&requests">Förfrågningar</a></li>
			</ul>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
				<?php if (!isset($_GET['invited']) && !isset($_GET['requests'])) {
					$members = sqlSelect("SELECT users.user_id, users.username, group_members.id, group_members.admin FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$_GET['view']} AND group_members.status = 1;"); ?>
					<div class="list-group">
					<?php foreach ($members as $member): ?>
						<blockquote>
							<a href="profile?view=<?=$member['user_id']; ?>"><?=$member['username']; ?></a>
							<?php if ($group_info[0]['admin'] == 1): ?>
								<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/delete_member?view=<?=$_GET['view']; ?>&delete=<?=$member['id']; ?>');">Ta bort medlem</button>
								<?php if ($member['admin'] == 0): ?>
								<button class="btn btn-default float-right" onClick="window.location.replace('form/get/group/make_admin?view=<?=$_GET['view']; ?>&admin=<?=$member['id']; ?>');">Ge adminstratörs-rättigheter</button>
								<?php else: ?>
								<button class="btn btn-default float-right" onClick="window.location.replace('form/get/group/remove_admin?view=<?=$_GET['view']; ?>&admin=<?=$member['id']; ?>');">Ta bort adminstratörs-rättigheter</button>
								<?php endif; endif; ?>
						</blockquote>
					<?php endforeach; ?>
					</div>
				<?php }
					
				if (isset($_GET['invited']) && empty($_GET['invited']) && !isset($_GET['requests'])) {
					if ($group_info[0]['admin'] == 1) {
						$members = sqlSelect("SELECT users.user_id, users.username, group_members.id FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$_GET['view']} AND group_members.user_id != {$_SESSION['user']['id']} AND group_members.status = 2;"); ?>
						<div class="list-group">
						<?php foreach ($members as $member): ?>
							<blockquote><a href="profile?view=<?=$member['user_id']; ?>"><?=$member['username']; ?></a><button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/decline_member?view=<?=$_GET['view']; ?>&decline=<?=$member['id']; ?>');">Dra tillbaka inbjudan</button></blockquote>
						<?php endforeach; ?>
						</div>
						<?php }
					else { ?>
						<h3>Du är inte admin och har inte behörighet till den här sidan.</h3>
					<?php }
				}
				if (!isset($_GET['invited']) && isset($_GET['requests']) && empty($_GET['requests'])) {
					if ($group_info[0]['admin'] == 1) {
						$members = sqlSelect("SELECT users.user_id, users.username, group_members.id FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$_GET['view']} AND group_members.user_id != {$_SESSION['user']['id']} AND group_members.status = 3;"); ?>
						<div class="list-group">
						<?php foreach ($members as $member): ?>
							<blockquote><a href="profile?view=<?=$member['user_id']; ?>"><?=$member['username']; ?></a><button class="btn btn-success float-right" onClick="window.location.replace('form/get/group/accept_member?view=<?=$_GET['view']; ?>&accept=<?=$member['id']; ?>');">Acceptera förfrågan</button></blockquote>
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
<section class="section" id="head">
	<div class="container">
		<?php if (!isset($_GET['requests'])): ?>
		<h1>Inbjudningar</h1>
		<?php else: ?>
		<h1>Ansökningar</h1>
		<?php endif; ?>
			<ul class="breadcrumb">
			  	<li><a href="groups?view=invites">Inbjudningar</a></li>
			  	<li><a href="groups?view=invites&requests">Ansökningar</a></li>
			</ul>
		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
				<?php
				$group = sqlSelect("SELECT group_members.id, groups.id AS group_id, groups.name FROM `group_members` INNER JOIN groups ON group_members.group_id = groups.id WHERE user_id = {$_SESSION['user']['id']} AND status = 2");
				foreach ($group as $invite): ?>
				<blockquote>
					<h3>
						<a href="groups?view=<?=$invite['group_id']; ?>"><?=$invite['name']; ?></a>
						<?php if (!isset($_GET['requests'])): ?>
						<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/undo_invite?id=<?=$invite['id']; ?>&group_id=<?=$invite['group_id']; ?>&view=requests');">Ångra</button>
						<?php else: ?>
						<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/reject_invite?id=<?=$invite['id']; ?>&group_id=<?=$invite['group_id']; ?>&view=invites');">Avböj</button>
						<button class="btn btn-success float-right" onClick="window.location.replace('form/get/group/accept_invite?id=<?=$invite['id']; ?>&group_id=<?=$invite['group_id']; ?>&view=invites');">Acceptera</button>
					<?php endif; ?>
					</h3>
				</blockquote>
				<?php endforeach; ?>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
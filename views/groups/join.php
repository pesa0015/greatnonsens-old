<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
				<?php
				$group = sqlSelect("SELECT group_members.id, groups.id AS group_id, groups.name, group_members.status FROM `group_members` INNER JOIN groups ON group_members.group_id = groups.id WHERE group_members.group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']};");
				?>
				<div class="jumbotron">
					<h3>Gå med</h3>
					<?php
					if ($group[0]['status'] == 2) { ?>
					<p>Du är inbjuden till den här gruppen.</p>
					<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/reject_invite?id=<?=$group[0]['id']; ?>&view=<?=$_GET['view']; ?>');">Avböj</button>
					<button class="btn btn-success float-right" onClick="window.location.replace('form/get/group/accept_invite?id=<?=$group[0]['id']; ?>&view=<?=$_GET['view']; ?>');">Acceptera</button>
					<?php } if ($group[0]['status'] == 3) { ?>
					<p>Du har ansökt till den här gruppen.</p>
					<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/reject_invite?id=<?=$group[0]['id']; ?>&view=<?=$_GET['view']; ?>');">Avböj</button>
					<button class="btn btn-success float-right" onClick="window.location.replace('form/get/group/accept_invite?id=<?=$group[0]['id']; ?>&view=<?=$_GET['view']; ?>');">Acceptera</button>
					<?php } if ($group[0]['status'] == 1) { ?>
					<p>Du är redan med i den här gruppen.</p>
					<?php } ?>
				</div>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
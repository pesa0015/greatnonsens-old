
				<?php
				$group = sqlSelect("SELECT group_members.id, groups.id AS group_id, groups.name, group_members.status FROM `group_members` INNER JOIN groups ON group_members.group_id = groups.id WHERE group_members.group_id = {$groupId} AND user_id = {$_SESSION['user']['id']};");
				
					if ($group_info[0]['open'] != 3): ?>
					<h3>Gå med</h3>
					<?php endif;
					if (isset($group[0]['status'])) {
					if ($group[0]['status'] == 2) { ?>
					<p>Du är inbjuden till den här gruppen.</p>
					<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/reject_invite?id=<?=$group[0]['id']; ?>&group_id=<?=$_GET['view']; ?>&view=<?=$_GET['view']; ?>');">Avböj</button>
					<button class="btn btn-success float-right" onClick="window.location.replace('form/get/group/accept_invite?id=<?=$group[0]['id']; ?>&group_id=<?=$_GET['view']; ?>&view=<?=$_GET['view']; ?>');">Acceptera</button>
					<?php } if ($group[0]['status'] == 3) { ?>
					<p>Du har ansökt till den här gruppen.</p>
					<button class="btn btn-danger float-right" onClick="window.location.replace('form/get/group/reject_invite?id=<?=$group[0]['id']; ?>&group_id=<?=$_GET['view']; ?>&view=<?=$_GET['view']; ?>');">Avböj</button>
					<button class="btn btn-success float-right" onClick="window.location.replace('form/get/group/accept_invite?id=<?=$group[0]['id']; ?>&group_id=<?=$_GET['view']; ?>&view=<?=$_GET['view']; ?>');">Acceptera</button>
					<?php } if ($group[0]['status'] == 1) { ?>
					<p>Du är redan med i den här gruppen.</p>
					<?php }}
					else {
					if ($group_info[0]['open'] == 1) { ?>
					<button class="btn btn-danger" onClick="window.location.replace('form/get/group/join?id=<?=$group_info[0]['id']; ?>&request=1&page=<?=$page; ?>');">Gå med</button>
					<?php } if ($group_info[0]['open'] == 2) { ?>
					<button class="btn btn-danger" onClick="window.location.replace('form/get/group/join?id=<?=$group_info[0]['id']; ?>&request=3&page=<?=$page; ?>');">Gå med</button>
					<?php } if ($group_info[0]['open'] == 3) { ?>
					<h3>Rekrytering är stängd.</h3>
					<?php }} ?>					
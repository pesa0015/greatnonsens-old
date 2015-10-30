			<h1><?=$group_info[0]['name']; ?></h1>
			<ul class="nav nav-pills">
				<?php if ($group_info[0]['user_id'] == $_SESSION['user']['id'] && $group_info[0]['status'] == 1) { ?>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'chat') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=chat">Chatt</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'news') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=news">Händelser</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'members') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=members">Medlemmar</a></li>
					<?php if ($group_info[0]['admin'] == 1): ?>
						<li<?php if (isset($_GET['show']) && $_GET['show'] == 'invite') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=invite">Bjud in</a></li>
					<?php endif; ?>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'description') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=description">Beskrivning</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'new_story') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=new_story">Skapa story</a></li>
				<?php }
				else {
					if ($group_info[0]['secret'] == 1) { ?>
					<div>Hemlig grupp. Ingen information delas med utomstående.</div>
				<?php }
					else { ?>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'chat') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=chat">Chatt</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'news') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=news">Händelser</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'members') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=members">Medlemmar</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'join') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=join">Gå med</a></li>
					<li<?php if (isset($_GET['show']) && $_GET['show'] == 'description') echo ' class="active"'; ?>><a href="groups?view=<?=$_GET['view']; ?>&show=description">Beskrivning</a></li>
				<?php }}

?>
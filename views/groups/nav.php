			<?php
			function isPage($menuItem) {
				global $page;
				return ($page === $menuItem) ? ' class="active"' : '';
			}
			?>
			<h1><?=$group_info[0]['name']; ?></h1>
			<?php if (!empty($member) && $member[0]['status'] == 2): ?>
				<div>Du har blivit inbjuden till den här gruppen.</div>
				<span class="btn btn-success" onclick="joinGroup();">Acceptera inbjudan</span>
			<?php endif; ?>
			<?php if (!empty($member) && $member[0]['status'] == 3): ?>
				<div>Du har ansökt om att gå med i den här gruppen.</div>
				<span class="btn btn-success" onclick="joinGroup();">Ångra ansökan</span>
			<?php endif; ?>
			<?php if (empty($member) && $group_info[0]['secret'] == 1): ?>
				<div>Hemlig grupp. Ingen information delas med utomstående.</div>
			<?php endif; ?>
			<?php if (empty($member) && $group_info[0]['open'] == 1): ?>
				<div>Du är inte med i den här gruppen.</div>
				<span class="btn btn-success" onclick="joinGroup();">Gå med</span>
			<?php endif; ?>
			<?php if (empty($member) && $group_info[0]['open'] == 2): ?>
				<div>Du är inte med i den här gruppen.</div>
				<span class="btn btn-success" onclick="joinGroup();">Gå med</span>
			<?php endif; ?>
			<?php if (empty($member) && $group_info[0]['open'] == 3): ?>
				<div>Medlemskap endast via rekrytering.</div>
			<?php endif; ?>
			<?php if ($group_info[0]['secret'] == 0): ?>
			<hr />
			<ul class="nav nav-pills">
				<?php if (!empty($member)): ?>
					<li<?=isPage('stories'); ?>><a href="groups/<?=$groupId; ?>/stories">Stories</a></li>
					<li<?=isPage('chat'); ?>><a href="groups/<?=$groupId; ?>/chat">Chatt</a></li>
					<li<?=isPage('news'); ?>><a href="groups/<?=$groupId; ?>/news">Händelser</a></li>
					<li<?=isPage('members'); ?>><a href="groups/<?=$groupId; ?>/members">Medlemmar</a></li>
					<?php if ($member[0]['admin'] == 1): ?>
						<li<?=isPage('invite'); ?>><a href="groups/<?=$groupId; ?>/invite">Bjud in</a></li>
					<?php endif; ?>
					<li<?=isPage('description'); ?>><a href="groups/<?=$groupId; ?>/description">Beskrivning</a></li>
					<li<?=isPage('new_story'); ?>><a href="groups/<?=$groupId; ?>/new_story">Skapa story</a></li>
				<?php else: ?>
					<li<?=isPage('stories'); ?>><a href="groups/<?=$groupId; ?>/stories">Stories</a></li>
					<li<?=isPage('chat'); ?>><a href="groups/<?=$groupId; ?>/chat">Chatt</a></li>
					<li<?=isPage('news'); ?>><a href="groups/<?=$groupId; ?>/news">Händelser</a></li>
					<li<?=isPage('members'); ?>><a href="groups/<?=$groupId; ?>/members">Medlemmar</a></li>
					<li<?=isPage('join'); ?>><a href="groups/<?=$groupId; ?>/join">Gå med</a></li>
					<li<?=isPage('description'); ?>><a href="groups/<?=$groupId; ?>/description">Beskrivning</a></li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
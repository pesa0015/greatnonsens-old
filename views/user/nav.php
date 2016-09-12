			<ul class="nav nav-pills">
				<?php if ($me): ?>
					<li<?=isPage(false); ?>><a href="user/<?=$_SESSION['user']['id']; ?>">Översikt</a></li>
					<li<?=isPage('settings'); ?>><a href="me/settings">Inställningar</a></li>
				<?php else: ?>
					
				<?php endif; ?>
			</ul>
			<hr />
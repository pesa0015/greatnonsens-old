				<?php
				if ($table == 'groups')
					$results = sqlSelect("SELECT id, name FROM groups WHERE name LIKE '%{$_GET['query']}%';");
				if ($table == 'users')
					$results = sqlSelect("SELECT user_id, username FROM users WHERE username LIKE '%{$_GET['query']}%';");
				if ($table == 'story')
					$results = sqlSelect("SELECT story_id, title FROM story WHERE name LIKE '%{$_GET['query']}%';");
				if ($results): ?>
					<div class="list-group">
					<?php foreach ($results as $result):
						if ($table == 'groups') { ?>
							<a href="groups/<?=$result['id']; ?>" class="list-group-item"><?=$result['name']; ?></a>
						<?php }
						if ($table == 'users') { ?>
						<a href="profile?view=<?=$result['user_id']; ?>" class="list-group-item"><?=$result['username']; ?></a> 
						<?php }
						if ($table == 'story') { ?>
						<a href="read?story=<?=$result['story_id']; ?>" class="list-group-item"><?=$result['title']; ?></a>
						<?php }
				endforeach; endif; ?>
				<div class="radio">
		        	<label>
		            	<input type="radio" name="radio" <?=(!$subPage) ? 'checked=""' : ''; ?> onClick="window.location.replace('groups/<?=$groupId; ?>/news');">Visa senaste
		        	</label>
		        </div>
		        <div class="radio">
		        	<label>
		            	<input type="radio" name="radio" <?=($subPage === 'oldest') ? 'checked=""' : ''; ?> onClick="window.location.replace('groups/<?=$groupId; ?>/news/oldest');">Visa äldsta
		        	</label>
		        </div>

<?php

if (!$subPage) 
					$news = sqlSelect("SELECT users.user_id, users.username, group_news_feed.type, group_news_feed.what, group_news_feed.date FROM `group_news_feed` INNER JOIN users ON users.user_id = group_news_feed.user_id WHERE group_news_feed.group_id = {$groupId} ORDER BY group_news_feed.id DESC;");
				else if ($subPage === 'oldest')
					$news = sqlSelect("SELECT users.user_id, users.username, group_news_feed.type, group_news_feed.what, group_news_feed.date FROM `group_news_feed` INNER JOIN users ON users.user_id = group_news_feed.user_id WHERE group_news_feed.group_id = {$groupId} ORDER BY group_news_feed.id ASC;");
				$i = 0;
				foreach ($news as $newsItem) {
					$i++;
					if ($i % 2 === 0)
						$color = '#4899B1;';
					else
						$color = '#2B5B6A;';
					?>

					<div class="panel panel-default">
						<div class="panel-heading" style="background: <?=$color; ?>">
							<?php
							if ($newsItem['type'] === 'edited_description') {
								echo ($newsItem['user_id'] == $_SESSION['user']['id']) ? 'Jag' : "<a href=\"profile?view={$newsItem['user_id']}\">{$newsItem['username']}</a>"; ?> ändrade gruppens beskrivning.
							<?php }
							if ($newsItem['type'] === 'group_created') {
								echo ($newsItem['user_id'] == $_SESSION['user']['id']) ? 'Jag' : "<a href=\"profile?view={$newsItem['user_id']}\">{$newsItem['username']}</a>"; ?> skapade gruppen.
							<?php }
							if ($newsItem['type'] === 'invited') {
								$json = json_decode($newsItem['what'], true);
								echo ($newsItem['user_id'] == $_SESSION['user']['id']) ? 'Jag' : "<a href=\"profile?view={$newsItem['user_id']}\">{$newsItem['username']}</a>"; ?> bjöd in <a href="profile?view=<?=$json['id']; ?> " style="color: #FFFFFF;"><?=$json['username']; ?></a>.
							<?php }
							if ($newsItem['type'] === 'invite_request') { ?>
								<a href="profile?view={$newsItem['user_id']}" style="color: #FFFFFF;"><?=$newsItem['username']; ?></a> vill gå med i gruppen.
								<div class="panel-body">
									<button class="btn btn-info" onClick="window.location.replace('groups?view=<?=$_GET['view']; ?>&show=invite&requests');">Hantera</button>
								</div>
							<?php }
							if ($newsItem['type'] === 'rejected_invite') {
								echo ($newsItem['user_id'] == $_SESSION['user']['id']) ? 'Jag' : "<a href=\"profile?view={$newsItem['user_id']}\" style=\"color: #FFFFFF;\">{$newsItem['username']}</a>"; ?> ignorerade inbjudan.
							<?php } ?>
						</div>
						<div class="panel-footer">
							<?=timeAgo($newsItem['date']); ?>
						</div>
					</div>
					<?php } ?>
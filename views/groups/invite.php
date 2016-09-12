<?php

				// $admin = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$groupId} AND user_id = {$_SESSION['user']['id']};");

				if ($member[0]['admin'] != 1): ?>
					<h3>Du är inte admin och har inte behörighet till den här sidan.</h3>
				<?php else: ?>

					
						
						<form action="" method="post" onsubmit="inviteGroupMembers(event);">
							<input type="hidden" name="group_id" value="<?=$groupId; ?>">
							<textarea id="select2_family" name="group_members" placeholder="Medlemmar" style="width: 300px;"></textarea>
							<input type="submit" class="btn btn-success" value="Bjud in">
						</form>
						<div id="success" class="success"><img src="assets/images/smileys/joy.png" alt=""><span class="success_text">Inbjudan har skickats.</span><span class="remove-result-box" onclick="$(this).parent().fadeOut(500);">Stäng</span></div>
					<?php endif; ?>
	
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
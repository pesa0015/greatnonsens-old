<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">	

				<?php

				$admin = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']};");

				if ($admin[0]['admin'] != 1) { ?>
					<h3>Du är inte admin och har inte behörighet till den här sidan.</h3>
				<?php }

				else {

					if (isset($_GET['requests']) && empty($_GET['requests'])) {
						$requests = sqlSelect("SELECT group_invites.id, users.user_id, users.username, group_invites.invite_access_to_previous_stories, group_invites.admin, group_invites.message, group_invites.date_sent FROM `group_invites` INNER JOIN users ON users.user_id = group_invites.user_id WHERE group_invites.group_id = 22 AND group_invites.sent_by IS NULL AND group_invites.date_sent IS NOT NULL AND group_invites.date_accepted IS NULL AND group_invites.date_left IS NULL;");
						if (count($requests) > 0) { ?>
							<div class="col-md-6">
							<?php
							foreach ($requests as $request) {
							?>
								<blockquote>
									<p><a href="player_info?user_id=<?=$request['user_id']; ?>"><?=$request['username']; ?></a> vill gå med i gruppen.
									<small><?=$request['date_sent']; ?></small>
									<?php
									if ($request['invite_access_to_previous_stories'] == 1 && $request['admin'] == 1) { ?>
									<p>Du får vara med i redan påbörjade stories samt admin-rättigheter.</p>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=yes&admin=yes&view=join');">Acceptera</button>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=no&admin=yes&view=join');">Acceptera men jag vill inte delta i påbörjade stories</button>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=yes&admin=no&view=join');">Acceptera men jag vill inte bli admin</button>
									<button class="btn btn-danger" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&decline=<?=$request['id']; ?>&view=join');">Ignorera</button>
									<?php }
									if ($request['invite_access_to_previous_stories'] == 1 && $request['admin'] == 0) { ?>
									<p>Du får vara med i redan påbörjade stories.</p>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=yes&admin=no&view=join');">Acceptera</button>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=no&admin=no&view=join');">Acceptera men jag vill inte delta i påbörjade stories</button>
									<button class="btn btn-danger" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&decline=<?=$request['id']; ?>&view=join');">Ignorera</button>
									<?php }
									if ($request['invite_access_to_previous_stories'] == 0 && $request['admin'] == 1) { ?>
									<p>Du får admin-rättigheter.</p>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=no&admin=yes&view=join');">Acceptera</button>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=no&admin=no&view=join');">Acceptera men jag vill inte bli admin</button>
									<button class="btn btn-danger" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&decline=<?=$request['id']; ?>&view=join');">Ignorera</button>
									<?php }
									else { ?>
									<button class="btn btn-success" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&join=<?=$request['id']; ?>&prev_stories=no&admin=no&view=join');">Acceptera</button>
									<button class="btn btn-danger" onClick="window.location.replace('groups?show=<?=$_GET['show']; ?>&decline=<?=$request['id']; ?>&view=join');">Ignorera</button>
									<?php }
							} ?>
								</blockquote>
							</div>
							<?php
						}
					}
					else { 
					?>
					<div class="col-md-6">
						<?php require 'form/show_errors.php'; ?>
						<form action="form/post/group/invite_members" method="post">
							<input type="hidden" name="group_id" value="<?=$_GET['view']; ?>">
							<textarea id="select2_family" name="group_members" placeholder="Medlemmar" style="width: 300px;"></textarea>
							<input type="submit" class="btn btn-success" value="Bjud in">
						</form>
					</div>
					<?php }} ?>
	
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
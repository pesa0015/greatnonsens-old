<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">	

				<?php

				$admin = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']};");

				if ($admin[0]['admin'] != 1): ?>
					<h3>Du är inte admin och har inte behörighet till den här sidan.</h3>
				<?php else: ?>

					<div class="col-md-6">
						<?php require 'form/show_errors.php'; ?>
						<form action="form/post/group/invite_members" method="post">
							<input type="hidden" name="group_id" value="<?=$_GET['view']; ?>">
							<textarea id="select2_family" name="group_members" placeholder="Medlemmar" style="width: 300px;"></textarea>
							<input type="submit" class="btn btn-success" value="Bjud in">
						</form>
					</div>
					<?php endif; ?>
	
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
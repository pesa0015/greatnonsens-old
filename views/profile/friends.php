<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
				<h1>Mina vänner</h1>
				<?php if ($friends):
				foreach ($friends as $friend): ?>
				<blockquote>
				<a href="profile?view=<?=$friend['user_id']; ?>" class="list-group-item"><?=$friend['username']; ?></a>
				<button onClick="window.location.replace('form/get/friends/delete?id=<?=$friend['friend_request_id']; ?>&friend=<?=$friend['user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>');" class="btn btn-danger float-right">Ta bort</button>
				</blockquote>
				<?php endforeach; endif; ?>

				<h1>Vänförfrågningar</h1>
				<?php if ($received_friend_requests):
				foreach ($received_friend_requests as $friend_request): ?>
				<blockquote>
				<a href="profile?view=<?=$friend_request['user_id']; ?>"><?=$friend_request['username']; ?></a>
				<button onClick="window.location.replace('form/get/friends/accept?id=<?=$friend_request['friend_request_id']; ?>&friend=<?=$friend_request['user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>');" class="btn btn-success float-right">Acceptera</button>
				<button onClick="window.location.replace('form/get/friends/reject?id=<?=$friend_request['friend_request_id']; ?>&friend=<?=$friend_request['user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>');" class="btn btn-danger float-right">Neka</button>
				</blockquote>
				<?php endforeach; endif; ?>

				<h1>Avvaktande vänförfrågningar</h1>
				<?php if ($sent_friend_requests):
				foreach ($sent_friend_requests as $friend_request): ?>
				<blockquote>
				<a href="profile?view=<?=$friend_request['user_id']; ?>"><?=$friend_request['username']; ?></a>
				<button onClick="window.location.replace('form/get/friends/undo?id=<?=$friend_request['friend_request_id']; ?>&friend=<?=$friend_request['user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>');" class="btn btn-danger float-right">Ångra</button>
				</blockquote>
				<?php endforeach; endif; ?>
				
				<h1>Lägg till vän</h1>

				<?php require 'form/show_errors.php'; ?>
				<form action="form/post/friends/add" method="post" class="navbar-form navbar-left">
				<textarea id="select2_family" name="friends" rows="2" style="width: 250px;"></textarea>
				<input type="submit" name="addFriend" value="Ok" class="btn btn-success">
				<!-- Show Results -->
			    </form>

			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
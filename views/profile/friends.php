<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">
				<h1>Mina vänner</h1>
	
	<?

	//echo "SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN (SELECT friends.friend_request_id, CASE WHEN friends.user_id = {$_SESSION['user']['id']} THEN friends.friend_user_id ELSE friends.user_id END person_id FROM friends WHERE (friends.user_id = {$_SESSION['user_id']} OR friends.friend_user_id = {$_SESSION['user']['id']}) AND pending = 1) friends ON users.user_id = friends.person_id;";

	$sql_friends = sqlSelect("SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN (SELECT friends.friend_request_id, CASE WHEN friends.user_id = {$_SESSION['user']['id']} THEN friends.friend_user_id ELSE friends.user_id END person_id FROM friends WHERE (friends.user_id = {$_SESSION['user']['id']} OR friends.friend_user_id = {$_SESSION['user']['id']}) AND pending = 1) friends ON users.user_id = friends.person_id;");

foreach ($sql_friends as $friend) { ?>
	<a href="player_info?user_id=<?=$friend['user_id']; ?>"><?=$friend['username']; ?></a>
	<button onClick="window.location.replace('friends?delete=friend&id=<?=$friend['friend_request_id']; ?>&user_id=<?=$friend['user_id']; ?>');" class="btn btn-danger">Ta bort</button>
	<? } 

?>

	<h1>Vänförfrågningar</h1>

<?

$sql_request = sqlSelect("SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN friends ON users.user_id = friends.user_id WHERE friend_user_id = {$_SESSION['user']['id']} AND pending = 0;");

foreach ($sql_request as $friend_request) { ?>
	<a href="player_info?user_id=<?=$friend_request['user_id']; ?>"><?=$friend_request['username']; ?></a>
	<button onClick="window.location.replace('friends?accept=friend&id=<?=$friend_request['friend_request_id']; ?>&user_id=<?=$friend_request['user_id']; ?>');" class="btn btn-success">Acceptera</button>
	<button onClick="window.location.replace('friends?delete=friend&id=<?=$friend_request['friend_request_id']; ?>&user_id=<?=$friend_request['user_id']; ?>');" class="btn btn-danger">Neka</button>
	<? } 

?>

	<h1>Avvaktande vänförfrågningar</h1>

	<?

$sql_friends = sqlSelect("SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN friends ON users.user_id = friends.friend_user_id WHERE friends.user_id = {$_SESSION['user']['id']} AND pending = 0;");

foreach ($sql_friends as $friend_request) { ?>
	<a href="player_info?user_id=<?=$friend_request['user_id']; ?>"><?=$friend_request['username']; ?></a>
	<button onClick="window.location.replace('friends?delete=friend&id=<?=$friend_request['friend_request_id']; ?>&user_id=<?=$friend_request['user_id']; ?>');" class="btn btn-danger">Ångra</button>
	<? }

?>
	
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
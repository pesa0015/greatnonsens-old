<section class="section" id="head">
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">

<h1><?=$sql_user[0]['username']; ?></h1>

<?php

$width_height = 'width="100" height="100"';

if (empty($sql_user[0]['profile_img'])): ?>
	<img id="check_img" src="user_content/user_img/default.png" <?=$width_height; ?> alt="Profilbild">
<?php
else: ?>
	<img id="check_img" src="user_content/user_img/<?=$sql_user[0]['profile_img']; ?>" <?=$width_height; ?> alt="Profilbild">
<?php endif;

echo '<hr />';

if ($_GET['view'] != $_SESSION['user']['id']) {
    $sql_friend = sqlSelect("SELECT friend_request_id, user_id, friend_user_id, status FROM `friends` WHERE user_id = {$_SESSION['user']['id']} AND friend_user_id = {$_GET['view']} OR user_id = {$_GET['view']} AND friend_user_id = {$_SESSION['user']['id']} ORDER BY friend_request_id DESC LIMIT 1;");
    if (isset($sql_friend) && !empty($sql_friend)) {
    	if ($sql_friend[0]['user_id'] == $_SESSION['user']['id'] && $sql_friend[0]['friend_user_id'] == $_GET['view'] && $sql_friend[0]['status'] == 0) { ?>
    		<h3>Vänförfrågan skickad.</h3>
    		<button onClick="window.location.replace('form/get/friends/undo?id=<?=$sql_friend[0]['friend_request_id']; ?>&friend=<?=$sql_friend[0]['friend_user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>&return_to_profile');" class="btn btn-danger">Ångra</button>
    		<?php }
    	if ($sql_friend[0]['user_id'] == $_GET['view'] && $sql_friend[0]['friend_user_id'] == $_SESSION['user']['id'] && $sql_friend[0]['status'] == 0) { ?>
    		<h2><?=$sql_user[0]['username']; ?> vill bli vän med dig.</h2>
    		<button onClick="window.location.replace('form/get/friends/accept?id=<?=$sql_friend[0]['friend_request_id']; ?>&friend=<?=$sql_friend[0]['user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>&return_to_profile');" class="btn btn-success">Acceptera</button>
    		<button onClick="window.location.replace('form/get/friends/reject?id=<?=$sql_friend[0]['friend_request_id']; ?>&friend=<?=$sql_friend[0]['user_id']; ?>&me=<?=$_SESSION['user']['id']; ?>&return_to_profile');" class="btn btn-danger">Neka</button>
    		<?php }
        if ($sql_friend[0]['status'] == 1) { ?>
    		<h3>Vänner <span class="ion-checkmark-round" style="font-size: 1em;"></span></h3>
    		<?php 
    	}
    }

    else if (empty($sql_friend)) { ?>
        <button onClick="window.location.replace('form/get/friends/add?friend=<?=$_GET['view']; ?>&return_to_profile');" class="btn btn-success">Skicka vänförfrågan</button>
    <?php
    }
}

if ($_GET['view'] == $_SESSION['user']['id'] && !isset($_GET['edit'])) { ?>
    <button onClick="window.location.replace('profile?view=<?=$_SESSION['user']['id']; ?>&edit');" class="btn btn-success">Redigera</button>
<?php
}

if ($_GET['view'] == $_SESSION['user']['id'] && isset($_GET['edit']) && empty($_GET['edit'])) { ?>
<form action="form/post/user/change_profile_img" method="post" enctype="multipart/form-data">
        <!-- <button id="open_file_dialog">Välj bild</button> -->
        <div class="fileUpload btn btn-primary">
            <span>Välj bild</span>
            <input type="file" id="fileToUpload" name="fileToUpload" class="upload">
        </div>
        <button type="submit" id="upload_img_disabled" class="btn btn-success disabled">Spara</button>
        <button type="submit" id="upload_img" name="upload_img" class="btn btn-success">Spara</button>
		<? 
		// User have profile image
		if (!empty($sql_user[0]['profile_img'])) { ?>
		<input type="hidden" name="replace" value="<?php echo $sql_user[0]['profile_img']; ?>">
        <button type="submit" name="delete" class="btn btn-danger">Ta bort bild</button>	
		<? } ?>
	</form>
    <script>
    if (document.getElementById('fileToUpload').value == '') {
        document.getElementById('upload_img_disabled').style.display = 'inline';
        document.getElementById('upload_img').style.display = 'none';
    }
    </script>
<hr />
<form action="form/post/user/change_profile_text" method="post">
		Personlig text
		<textarea rows="5" id="update" name="update" style="resize: vertical;"><?=htmlspecialchars($sql_user[0]['personal_text']); ?></textarea><br />
		<button type="submit" name="edit_text" class="btn btn-success">Spara</button>
	</form>
<?php }
else { ?>
<h2>Personlig text</h2>

<?

	if (!empty($sql_user[0]['personal_text'])) {
		echo htmlspecialchars($sql_user[0]['personal_text']);
	}
}

?>

            </div> <!-- /col -->
        </div> <!-- /row -->
    
    </div>
</section>
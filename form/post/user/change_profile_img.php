<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	@$target_file = $_FILES["fileToUpload"]["name"];
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

	if (isset($_POST["upload_img"])) {

	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

	    if ($check !== false) {
	        $uploadOk = 1;
	    } 

	    else {
	        echo "Filen är inte en bild.";
	        $uploadOk = 0;
	    }

	    if ($_FILES["fileToUpload"]["size"] > 500000) {
	        echo "Filen är för stor.";
	        $uploadOk = 0;
	    }

	    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	    && $imageFileType != "gif") {
	        echo "Bilden måste vara JPG, JPEG, PNG eller GIF.";
	        $uploadOk = 0;
	    }

	    if ($uploadOk == 0) {
	        echo "Filuppladdningen misslyckades.";
	    } 

	    else {
	        if (isset($_POST['replace'])) {
	            $current_img = sqlEscape($_POST['replace']);
	            unlink("../../../user_content/user_img/$current_img");
	        }
	        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../../../user_content/user_img/" . "{$_SESSION['user']['id']}" . ".$imageFileType");
	        sqlAction("UPDATE users 
	            SET profile_img = '{$_SESSION['user']['id']}.$imageFileType' WHERE user_id = {$_SESSION['user']['id']};");
	        header("Location: ../../../profile?view={$_SESSION['user']['id']}");
	    }
	}

	else if (isset($_POST["delete"])) {

		$current_img = sqlEscape($_POST['replace']);

		if (!empty($current_img)) {

			unlink('../../../user_content/user_img/' . $current_img);
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "./../../user_content/user_img/" . "{$_SESSION['user']['id']}" . ".$imageFileType");
			sqlAction("UPDATE users SET profile_img = '' WHERE user_id = {$_SESSION['user']['id']};");
			header("Location: ../../../profile?view={$_SESSION['user']['id']}");
		}

		// else {
		// 	echo "<script>alert('Det finns ingen bild att ta bort.');</script>";
		// }
	}
}

?>
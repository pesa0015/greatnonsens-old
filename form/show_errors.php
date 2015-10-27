<?php

	if (isset($_SESSION['errors'])) { 
		foreach ($_SESSION['errors'] as $error) { ?>
			<div class="alert alert-dismissible alert-info col-lg-4 col-lg-offset-4"><?=$error; ?></div>
		<?php }
	}

?>
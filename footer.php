		</div> <!-- END #WRAPPER -->
		<script src="assets/js/jquery-1.11.1.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="https://cdn.firebase.com/js/client/2.3.1/firebase.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js"></script>
		<script src="assets/js/jquery.noty.packaged.min.js"></script>
		<script src="assets/js/jquery.timeago.js"></script>
		<script src="http://momentjs.com/downloads/moment.js"></script>
		<script src="assets/js/livestamp.min.js"></script>
		<script src="assets/js/validator.min.js"></script>
		<script src="assets/js/spin.min.js"></script>
		<script src="js/firebase_url.js"></script>
		<script src="js/main.php"></script>
		<?php if (isset($script)): ?>
		<script src="<?=$script; ?>"></script>
		<?php endif; ?>
		<!--<script src="js/script.js"></script>-->
		<?php if (isset($_SESSION['noty_message'])): ?>
			<script>var n = noty({text: '<?=$_SESSION['noty_message']['text']; ?>', type: '<?=$_SESSION['noty_message']['type']; ?>', dismissQueue: '<?=$_SESSION['noty_message']['dismissQueue']; ?>', layout: '<?=$_SESSION['noty_message']['layout']; ?>', theme: '<?=$_SESSION['noty_message']['theme']; ?>', timeout: '<?=$_SESSION['noty_message']['timeout']; ?>'});</script>
		<?php unset($_SESSION['noty_message']);
		endif;
		if (isset($_SESSION['errors'])) unset($_SESSION['errors']);
		?>
	</body>
</html>
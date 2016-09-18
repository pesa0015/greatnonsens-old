		</div> <!-- END #WRAPPER -->
		</div> <!-- END #CONTENT -->
		</div> <!-- END #WRAPPER -->
		<script src="assets/js/jquery-1.11.1.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/pusher.min.js"></script>
		<script src="js/pusher_config.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js"></script>
		<script src="assets/js/jquery.noty.packaged.min.js"></script>
		<script src="http://momentjs.com/downloads/moment.js"></script>
		<script src="assets/js/cookies.min.js"></script>
		<script>var me = <?=$_SESSION['me']['id']; ?>;</script>
		<script src="js/main.js"></script>
		<?php if (isset($script)): ?>
		<script id="page-js" src="<?=$script; ?>"></script>
		<div id="new-script"></div>
		<?php endif; ?>
		<!--<script src="js/script.js"></script>-->
		<?php if (isset($_SESSION['noty_message'])): ?>
			<script>var n = noty({text: '<?=$_SESSION['noty_message']['text']; ?>', type: '<?=$_SESSION['noty_message']['type']; ?>', dismissQueue: '<?=$_SESSION['noty_message']['dismissQueue']; ?>', layout: '<?=$_SESSION['noty_message']['layout']; ?>', theme: '<?=$_SESSION['noty_message']['theme']; ?>', timeout: '<?=$_SESSION['noty_message']['timeout']; ?>'});</script>
		<?php unset($_SESSION['noty_message']);
		endif;
		if (isset($_SESSION['errors'])) unset($_SESSION['errors']);
		?>
		<!--<script>var n1 = noty({text: 'test', type: 'success', layout: 'center', timeout: '1000'});</script>-->
	</body>
</html>
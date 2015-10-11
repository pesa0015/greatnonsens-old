		</div> <!-- END #WRAPPER -->
		<script src="vendor/js/jquery-1.11.1.min.js"></script>
		<script src="vendor/js/bootstrap.min.js"></script>
		<script src="vendor/js/jquery.noty.packaged.min.js"></script>
		<script src="js/script.js"></script>
		<?php if (isset($_GET['view']) && $_GET['view'] == 'new_story') { ?>
		    <script type="text/javascript">
		        $(window).load(function(){
		            $('#newStoryModal').modal('show');
		        });
		    </script>
		<?php } if (isset($_GET['view']) && $_GET['view'] == 'choose_story') { ?>
		    <script type="text/javascript">
		        $(window).load(function(){
		            $('#writeModal').modal('show');
		        });
		    </script>
		<?php }
		if (isset($_SESSION['noty_message'])) { ?>
		    <script>
		    	var n = noty({
			        text        : '<?=$_SESSION['noty_message']['text']; ?>',
			        type        : '<?=$_SESSION['noty_message']['type']; ?>',
			        dismissQueue: '<?=$_SESSION['noty_message']['dismissQueue']; ?>',
			        layout      : '<?=$_SESSION['noty_message']['layout']; ?>',
			        theme       : '<?=$_SESSION['noty_message']['theme']; ?>',
			        timeout 	: '<?=$_SESSION['noty_message']['timeout']; ?>'
			        });
		    </script>
		<?php unset($_SESSION['noty_message']); }
		if (isset($_SESSION['errors']))
			unset($_SESSION['errors']);
		if (isset($_SESSION['login']))
			unset($_SESSION['login']);
		if (isset($_SESSION['register']))
			unset($_SESSION['register']);
		?>
	</body>
</html>
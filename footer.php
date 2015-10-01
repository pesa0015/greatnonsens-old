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
			        text        : '<?=$translate['noty_message']['new_story_created']['text']; ?>',
			        type        : '<?=$translate['noty_message']['new_story_created']['type']; ?>',
			        dismissQueue: '<?=$translate['noty_message']['new_story_created']['dismissQueue']; ?>',
			        layout      : '<?=$translate['noty_message']['new_story_created']['layout']; ?>',
			        theme       : '<?=$translate['noty_message']['new_story_created']['theme']; ?>',
			        timeout 	: '<?=$translate['noty_message']['new_story_created']['timeout']; ?>'
			        });
		    </script>
		<?php unset($_SESSION['noty_message']); } ?>
	</body>
</html>
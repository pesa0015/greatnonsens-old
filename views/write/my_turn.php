<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
				<form action="form/post/story/write" method="post">
			      <input type="hidden" name="story" value="<?=$_GET['story']; ?>">
			      <textarea id="app" class="form-control" name="words" rows="5" cols="50" placeholder="Skriv något..."></textarea><br/>
			      <input type="submit" name="send" class="btn btn-success" value="Skicka">
			    </form>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>
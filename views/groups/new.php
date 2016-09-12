<div class="page-header">
					<h1>Skapa grupp</h1>
				</div>
			<?php require 'form/show_errors.php'; ?>
			<form action="form/post/group/new" method="post" class="form-horizontal">
				  <fieldset>
				    <div class="form-group">
				      <label class="col-lg-2 control-label">Gruppnamn</label>
				      <div class="col-lg-10">
				        <input type="text" name="name" <?=(isset($_SESSION['group']['name'])) ? "value=\"{$_SESSION['group']['name']}\"" : ''; ?> class="form-control">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="col-lg-2 control-label">Beskrivning</label>
				      <div class="col-lg-10">
				        <textarea name="description" <?=(isset($_SESSION['group']['description'])) ? "value=\"{$_SESSION['group']['description']}\"" : ''; ?> class="form-control" rows="3"></textarea>
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="col-lg-2 control-label">Medlemmar</label>
				      <div class="col-lg-10">
				        <textarea id="select2_family" name="group_members" rows="2" style="width: 410px;"><?=(isset($_SESSION['group']['group_members'])) ? "value=\"{$_SESSION['group']['group_members']}\"" : ''; ?></textarea>
				      </div>
				    </div>
				    <div class="form-group">
					    <label class="col-lg-2 control-label">Hemlig</label>
					    <div class="col-lg-10">
							<div class="radio">
								<label>
									<input type="radio" id="group_not_secret" name="secret" value="0" checked="" onchange="checkIfSecret();"> Nej
								</label>
							</div>
							<div class="radio">
			          			<label>
									<input type="radio" id="group_secret" name="secret" value="1" onchange="checkIfSecret();"> Ja
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
					    <label class="col-lg-2 control-label">Inbjudan</label>
					    <div class="col-lg-10">
							<div class="radio">
								<label>
									<input type="radio" class="invite" name="open" value="1"> Öppen
								</label>
							</div>
							<div class="radio">
			          			<label>
									<input type="radio" class="invite" name="open" value="2" checked=""> Ansökan
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" class="invite" name="open" value="3"> Stängd
								</label>
							</div>
						</div>
					</div>
					<p>Inställningarna kan ändras när som helst.</p>
				    <div class="form-group">
				      <div class="col-lg-10 col-lg-offset-2">
				        <input type="submit" class="btn btn-success" value="Skapa">
				      </div>
				    </div>
				  </fieldset>
				</form>
<?php if (isset($_SESSION['group'])) unset($_SESSION['group']); ?>
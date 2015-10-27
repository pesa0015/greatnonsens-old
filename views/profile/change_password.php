<section class="section" id="head">
  <div class="container">

    <div class="row">
      <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">
        <form action="form/post/user/change_password" method="post" class="form-horizontal">
        	<fieldset>
            <legend>Byt lösenord</legend>
            <div class="form-group">
              <label for="password" class="col-lg-2 control-label">Nuvarande lösenord</label>
              <div class="col-lg-10">
                <input type="password" name="current_pwd" id="password" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="new_password" class="col-lg-2 control-label">Nytt lösenord</label>
              <div class="col-lg-10">
                <input type="password" name="new_pwd" id="new_password" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </fieldset>
        </form>
      </div> <!-- /col -->
    </div> <!-- /row -->
  
  </div>
</section>

<?php

if (isset($_SESSION['password_success'])) { ?>
<div class="alert alert-dismissible alert-success col-lg-2">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <span class="ion-checkmark-circled"></span> Lösenordet har ändrats.
</div>
<?php unset($_SESSION['password_success']); } ?>
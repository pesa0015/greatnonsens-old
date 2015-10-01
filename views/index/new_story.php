<div class="modal fade" id="newStoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Skapa en story</h4>
      </div>
      <div class="modal-body">
        <form action="post/new_story.php" method="post">
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <label for="name" class="control-label"><h5>Arbetsnamn:</h5></label>
                <input type="text" name="name" class="form-control" autofocus>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Öppningsmening:</h5>
                <textarea class="form-control" rows="3"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Max antal författare:</h5>
                <select class="form-control" id="max_writers">
                  <option value="10" selected>10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Flexibel:</h5>
                <div class="radio">
                  <label><input type="radio" name="flexible" id="flexible_no" value="option1" checked="">Nej</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="flexible" id="flexible_yes" value="option2">Ja</label>
                </div>
              </div>
            </div>
          </div>
          <div id="rounds" class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Rundor:</h5>
                <select class="form-control" id="num_of_rounds">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="more_rounds"> Fler
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div id="add_rounds" class="row" style="display: none;">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Antal rundor: <input type="text" name="name" class="form-control" style="width: 70px; display: inline; margin-left: 10px;"></h5>
              </div>
            </div>
          </div>
          <div id="div_story_length" class="row" style="display: none;">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Längd på storyn:</h5>
                <select id="select_story_length" class="form-control">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="75">75</option>
                  <option value="100">100</option>
                </select>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="longer_story"> Längre
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div id="add_length" class="row" style="display: none;">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Längd: <input type="text" name="name" class="form-control" style="width: 70px; display: inline; margin-left: 10px;"></h5>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Nonsensläge:</h5>
                <div class="radio">
                  <label><input type="radio" name="nonsensmode" id="optionsRadios2" value="option2" checked="">Ja</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="nonsensmode" id="optionsRadios1" value="option1">Nej</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <h5>Jag vill vara administratör av storyn:</h5>
                <div class="radio">
                  <label><input type="radio" name="admin" id="optionsRadios2" value="option2" checked="">Ja</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="admin" id="optionsRadios1" value="option1">Nej</label>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" name="new_story" value="Skapa" class="btn btn-success">
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  var more_rounds = document.getElementById('more_rounds');
  var num_of_rounds = document.getElementById('num_of_rounds');
  var add_rounds = document.getElementById('add_rounds');
  var add_length = document.getElementById('add_length');
  var longer_story = document.getElementById('longer_story');
  var select_story_length = document.getElementById('select_story_length');
  more_rounds.addEventListener('click', function() {
      if (!num_of_rounds.disabled) {
        num_of_rounds[0].innerHTML = '<option value=""></option>';
        num_of_rounds.disabled = true;
        add_rounds.style.display = 'block';
      }
      else {
        num_of_rounds[0].innerHTML = '<option value="1">1</option>';
        num_of_rounds.disabled = false;
        add_rounds.style.display = 'none';
      }
  });

  longer_story.addEventListener('click', function() {
      if (!select_story_length.disabled) {
        select_story_length[0].innerHTML = '<option value=""></option>';
        select_story_length.disabled = true;
        add_length.style.display = 'block';
      }
      else {
        select_story_length[0].innerHTML = '<option value="1">1</option>';
        select_story_length.disabled = false;
        add_length.style.display = 'none';
      }
  });

var flexible_yes = document.getElementById('flexible_yes');
var flexible_no = document.getElementById('flexible_no');
var rounds = document.getElementById('rounds');

flexible_yes.addEventListener('click', function() {
  if (rounds.style.display != 'none') {
    if (add_rounds.style.display == 'block')
      add_rounds.style.display = 'none';
    if (more_rounds.checked)
      more_rounds.checked = false;
    if (num_of_rounds.disabled) {
      num_of_rounds[0].innerHTML = '<option value="1">1</option>';
      num_of_rounds.disabled = false;
    }
    rounds.style.display = 'none';
    div_story_length.style.display = 'block';
  }  
});

flexible_no.addEventListener('click', function() {
  if (rounds.style.display == 'none') {
    if (longer_story.checked)
      longer_story.checked = false;
    if (add_length.style.display == 'block')
      add_length.style.display = 'none';
    if (select_story_length.disabled) {
      select_story_length[0].innerHTML = '<option value="10">10</option>';
      select_story_length.disabled = false;
    }
    rounds.style.display = 'block';
    div_story_length.style.display = 'none';
  }
});
</script>
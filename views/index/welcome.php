<div id="welcome" class="welcome">
  <h1>Great nonsens</h1>
  <h2>Skriv några ord. Låt en vän fortsätta.</h2>
</div>
<div class="md-modal md-effect-1" id="chooseStoryModal">
      <div class="md-content">
        <h3>Gå med i en story</h3>
        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>Titel</th>
              <th>Inledningsmening</th>
              <th>Nonsensläge</th>
              <th>Deltagare</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button class="md-close">Avbryt</button>
      </div>
    </div>
<div class="md-modal md-effect-1" id="createStoryModal">
  <form action="" method="post" id="create-story">
    <p>Inledningsord:</p>
    <div id="char-left" style="padding-top:15px;"><span>50</span> tecken kvar</div>
    <textarea id="opening-words" class="form-control" rows="3" maxlength="50"></textarea>
    <p>Vad ska berättelsen heta?</p>
    <input type="text" id="title" class="form-control">
    <p>Nonsensläge:</p>
    <div class="radio">
      <label>
        <input type="radio" name="nonsensmode" id="nonsens-mode" value="1" checked><span>Ja</span>
      </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="nonsensmode" id="nonsens-mode" value="0"><span>Nej</span>
      </label>
    </div>
    <p>Rundor:</p>
    <input type="text" id="rounds" value="5" class="form-control" style="width:50px;">
    <p>Max antal författare:</p>
    <input type="text" id="num-of-writers" value="10" class="form-control" style="width:50px;">
    <p>Öppen för alla:</p>
    <div class="radio">
      <label>
        <input type="radio" name="public" value="1"><span>Ja</span>
      </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="public" value="0" checked><span>Nej, endast via länk-inbjudning</span>
      </label>
    </div>
    <input type="submit" value="Skapa" class="btn btn-primary">
  </form>
</div>
<div id="start">
  <button id="new-story" class="button">Skapa en ny story <span class="ion-forward"></span></button>
  <button id="choose-story" class="button">Fortsätt skriv <span class="ion-edit"></span></button>
</div>
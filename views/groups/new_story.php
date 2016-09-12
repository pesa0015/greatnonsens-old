<form action="form/post/story/new_with_group" method="post" id="create-story">
    <input type="hidden" name="group_id" value="<?=$groupId; ?>">
    <p>Inledningsord:</p>
    <div id="char-left" style="padding-top:15px;"><span>50</span> tecken kvar</div>
    <textarea id="opening-words" class="form-control" name="text" rows="3" maxlength="50">Det var en gång</textarea>
    <p>Vad ska berättelsen heta?</p>
    <input type="text" id="title" name="title" class="form-control" value="Berg ">
    <p>Rundor:</p>
    <input type="text" id="rounds" name="rounds" value="5" class="form-control" style="width:50px;">
    <input type="submit" value="Skapa" class="btn btn-primary">
  </form>
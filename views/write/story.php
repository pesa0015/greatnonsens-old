<script>
  function hideElement(element) {
    if (document.getElementById(element).style.display == 'block') 
      document.getElementById(element).style.display = 'none';
  }
</script>

<div id="continue-story">
  <a href="invite_form" class="btn btn-default spoilerButton" onClick="hideElement('finish_story');">Bjud in <span class="ion-ios-personadd"></span></a>
  <a href="finish_story" class="btn btn-default spoilerButton" onClick="hideElement('invite_form');">Avsluta storyn <span class="ion-ios-paperplane"></span></a>
  <div id="invite_form" class="spoiler">
    <br />
    <form action="" method="post">
      <input type="hidden" name="story" value="<?=$story; ?>">
      <input type="hidden" name="flexible" value="<?=$flexible[0]['flexible']; ?>">
      <input type="text" id="select2_family" name="invite_writers" placeholder="Bjud in författare..." style="width: 300px;">
      <input type="submit" name="invite_to_single_story" class="btn btn-primary" value="Bjud in">
    </form>
  </div>
  <div id="finish_story" class="spoiler">
    <br />
    <p>Är du säker på att du vill avsluta den här storyn?<br />Om ja, kommer den att "stängas" och räknas som färdig.<br />Åtgärden kan ändras när som helst genom att förlänga storyn.</p>
    <form action="read?story=<?=$story; ?>" method="post">
      <input type="hidden" name="story" value="<?=$story; ?>">
      <input type="submit" name="finish_story" class="btn btn-primary" value="Avsluta storyn">
    </form>
  </div>
  <hr />  
  <form action="" method="post" id="trueStory">
          <?php echo @$not_sent; ?>
          <div id="charCounter">
            <span id="charLeft">50</span> <?=$translate['Characters_left']; ?>
          </div>
          <br />
          <ul class="nav nav-tabs">
            <?php
            if (isset($sql_latest)) { ?>
            <li class="active"><a href="#latest_words" data-toggle="tab">Senaste</a></li>
            <?php }
            else if (isset($sql_last_rows)) { ?>
            <li class="active"><a href="#last_words" data-toggle="tab">Tidigare</a></li>
            <?php } ?>
            <li><a href="#writers" data-toggle="tab">Deltagare</a></li>
            <li><a href="#rows_left" data-toggle="tab">Slut om</a></li>
          </ul>
          <br />
          <div id="myTabContent" class="tab-content">
            <?php
            if (isset($sql_latest)) { ?>
            <div class="tab-pane fade active in" id="latest_words">
              <p><div id="recent-row"><?=htmlspecialchars($sql_latest[0]['words']); ?><br /></div></p>
            </div>
            <?php }
            else if (isset($sql_last_rows)) { ?>
            <div class="tab-pane fade active in" id="last_words">
              <p><div id="recent-row"><?=htmlspecialchars($sql_last_rows[0]['words']); ?><br /></div></p>
            </div>
            <?php } ?>
            <div class="tab-pane fade" id="writers">
              <p>
                <?php
                foreach ($writers as $writers2) {
                  if (++$i === $num_of_writers) { ?>
                    <a href="player_info?user_id=<?=$writers2['user_id']; ?>"><?=htmlspecialchars($writers2['username']); ?></a><br /><?php 
                  }
                  else { ?>
                    <a href="player_info?user_id=<?=$writers2['user_id']; ?>"><?=htmlspecialchars($writers2['username']); ?></a>, <?php   
                  }
                } ?>
              </p>
            </div>
            <div class="tab-pane fade" id="rows_left">
              <p>Berättelsen är slut om <?=$sql_rows_left[0]['rows_left']; ?> rader</p>
            </div>
          </div>
          <br />
          <textarea id="app" name="words" rows="10" cols="50" placeholder="Write something..."></textarea><br/>
          <div id="charError"><?php echo $error; ?></div><br />
          <input type="submit" class="btn btn-default" name="send_row" value="Skicka">
          <div id="charCorrect"><?php echo $correct; ?></div><br />
      
      </form>

  </div> <!-- END #CONTINUE-STORY-MOBILE -->
<ul class="breadcrumb">
	<li><a href="groups/<?=$groupId; ?>/stories">Översikt</a></li>
	<li><a href="groups/<?=$groupId; ?>/stories/started">Pågående</a></li>
	<li><a href="groups/<?=$groupId; ?>/stories/finished">Färdiga</a></li>
</ul>
<?php
if (!$subPage):
$stories = sqlSelect("SELECT story_id, title, status FROM `story` WHERE with_group = {$groupId};");
if ($stories): foreach($stories as $story): ?>
<div class="panel panel-success">
  	<div class="panel-heading">
    	<h3 class="panel-title">
    		<?php if (!empty($member)): ?>
    		<a href="write?story=<?=$story['story_id']; ?>"><?=$story['title']; ?></a></h3>
    		<?php else: echo $story['title']; ?>
    		<?php endif; ?>
  	</div>
  	<div class="panel-body">
  		<?php if ($story['status'] == 1): ?>
  		<span>Pågår</span>
  		<?php elseif ($story['status'] == 2): ?>
  		<span>Färdig</span>
  		<?php endif; ?>
  	</div>
</div>
<?php endforeach;endif;endif; ?>
<?php

require 'session.php';

require 'lang/list.php';

if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
	header('Location: index');
}

require 'lang/config.php';

if (isset($_SESSION['user']))
	$groups = sqlSelect("SELECT DISTINCT(groups.id), groups.name FROM groups INNER JOIN `groups_activity_history` ON groups.id = groups_activity_history.group_id WHERE user_id = {$_SESSION['user']['id']} ORDER BY groups_activity_history.id DESC LIMIT 5;");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Great nonsens</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<!-- Bootstrap itself -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css">
	<link rel="stylesheet" href="assets/css/magister.css">
	<link rel="stylesheet" href="assets/css/ionicons.min.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- Fonts -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
</head>

<!-- use "theme-invert" class on bright backgrounds, also try "text-shadows" class -->
<body class="theme-invert">
<header>
	<h1><a href="/">&lt;?&gt;</a></h1>
	<?php if (isset($_SESSION['user'])): ?>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sök <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="search?after=group">Grupp</a></li>
	            <li><a href="search?after=user">Spelare</a></li>
	          </ul>
	        </li>
	      	<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Grupper <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="groups?view=new">Skapa ny grupp</a></li>
	            <li><a href="groups?view=invites">Inbjudan</a></li>
	            <?php if ($groups): ?>
	            <li class="divider"></li>
	            <?php foreach ($groups as $group): ?>
	            <li><a href="groups?view=<?=$group['id']; ?>"><?=$group['name']; ?></a></li>
	        	<?php endforeach; ?>
	        	<li class="divider"></li>
	        	<?php endif; ?>
	            <li><a href="groups?view=my_groups">Mer</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$_SESSION['user']['name']; ?> <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="profile?view=<?=$_SESSION['user']['id']; ?>">Profil</a></li>
	            <li><a href="profile?view=friends">Vänner</a></li>
	            <li><a href="profile?view=change_password">Byt lösenord</a></li>
	          </ul>
	        </li>
	        <li id="news_icon" class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Händelser <span class="badge"></span></a>
	          <ul id="news" class="dropdown-menu" role="menu">
	            <li id="nothing_happened">Ingeting nytt har hänt</li>
	            <li id="newsitem_read">Markera alla som lästa</li>
	          </ul>
	        </li>
	        <li><a href="logout">Logga ut</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
<?php endif; ?>
</header>
<?php if (!isset($_SESSION['user'])): ?>
<nav class="mainmenu">
	<div class="container">
		<div class="dropdown">
			<button type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<!-- <a data-toggle="dropdown" href="#">Dropdown trigger</a> -->
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a href="signup">Registrera</a></li>
			</ul>
		</div>
		<form action="form/post/user/auth.php" method="post">
			<input type="text" name="user" placeholder="Användarnamn"><input type="password" name="password" placeholder="Lösenord"><input type="submit" name="submit" value="Logga in">
		</form>
		<?php endif; ?>
	</div>
</nav>
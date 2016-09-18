<?php

require 'session.php';

require 'lang/list.php';

if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
	header('Location: index');
}

require 'lang/config.php';

require 'lib/Pusher/config.php';

if (isset($_SESSION['user'])) {
	$groups = sqlSelect("SELECT DISTINCT(groups.id), groups.name FROM groups INNER JOIN `group_members` ON groups.id = group_members.group_id WHERE user_id = {$_SESSION['user']['id']} AND group_members.status = 1 ORDER BY groups.id DESC LIMIT 5;");
}

$userNews = sqlSelect("SELECT users_news_feed.id, have_read, news_type.type, groups.id AS group_id, name AS group_name, story.story_id, title, users.user_id, username FROM users_news_feed LEFT JOIN groups ON groups.id = users_news_feed.group_id LEFT JOIN story ON story.story_id = users_news_feed.story_id LEFT JOIN users ON users.user_id = users_news_feed.writer_id INNER JOIN `news_type` ON news_type.id = users_news_feed.type_id WHERE users_news_feed.user_id = {$_SESSION['me']['id']} AND have_read = 0;");
if ($userNews) {
	$newsRead = array();
	$newsWrite = array();
	$news = array();
	$i = 0;
	foreach($userNews as $n) {
		switch ($n['type']) {
			case 'story_finished':
				$newsRead[$i]['news_id'] = $n['id'];
				$newsRead[$i]['link'] = 'read/' . $n['story_id'];
				$newsRead[$i]['story_id'] = $n['story_id'];
				$newsRead[$i]['title'] = $n['title'];
				$newsRead[$i]['text'] = $translate[$n['type']];
				break;
			case 'my_turn':
			case 'story_began':
				$newsWrite[$i]['news_id'] = $n['id'];
				$newsWrite[$i]['link'] = 'write/' . $n['story_id'];
				$newsWrite[$i]['story_id'] = $n['story_id'];
				$newsWrite[$i]['title'] = $n['title'];
				$newsWrite[$i]['text'] = $translate[$n['type']];
				break;
			default:
				$page = (!empty($n['group_id'])) ? 'groups' : 'users';
				$id = (!empty($n['group_id'])) ? $n['group_id'] : $n['user_id'];
				$name = (!empty($n['group_name'])) ? $n['group_name'] : $n['username']; 
				$news[$i]['news_id'] = $n['id'];
				$news[$i]['link'] = $page . '/' . $id;
				// $news[$i]['target_id'] = isset($n['group_id']) || isset($n['user_id']);
				$news[$i]['name'] = $name;
				$news[$i]['text'] = $translate[$n['type']];
				break;
		}
		$i++;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Great nonsens - Stafettskrivning. Till slut blir det en galen eller fantastisk berättelse eller helt enkelt bara ren nonsens.">
	
	<title>Great nonsens</title>
	<?php $href = (isset($baseHref)) ? $baseHref : ''; ?>
	<base href="<?=$href; ?>" />
	<link rel="shortcut icon" href="assets/images/g.png">
	<!-- Bootstrap itself -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css">
	<link rel="stylesheet" href="assets/css/magister.css">
	<link rel="stylesheet" href="assets/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/component.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- Fonts -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- <link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'> -->
</head>

<!-- use "theme-invert" class on bright backgrounds, also try "text-shadows" class -->
<body class="theme-invert">
	<div class="md-overlay"></div>
	<div id="wrapper">
	<?php if (isset($_COOKIE['cookie_information']) && $_COOKIE['cookie_information'] || isset($cookie_information) && !isset($loginPage)): ?>
	<div id="login-signup-cookies-area">
		<?php if (!isset($_SESSION['user'])): ?>
		<form action="form/post/user/auth" method="post" id="login-form">
			<span>Användarnamn: </span>
			<input type="text" name="user" autofocus>
			<span>Lösenord: </span>
			<input type="password" name="password">
			<input type="submit" name="login" value="Logga in" style="padding-bottom: 1px; margin-right: 10px;">
		</form>
		<span style="margin-right: 10px;"> | </span>
		<a href="signup">Registrera</a>
		<span style="margin-left: 10px; margin-right: 10px;"> | </span>
		<?php endif; ?>
		<span><a href="">Great nonsens använder cookies</a></span>
		<span style="margin-left: 10px; margin-right: 10px;"> | </span>
		<span id="close-cookie-info" class="ion-ios-close-outline" style="font-size: 20px; vertical-align: middle;"></span>
	</div>
	<?php endif; ?>
	<header>
		<a href="/" id="logo"><img src="assets/images/g.png" style="width:35px;" alt=""></a>
		<div id="header-icons">
			<div class="top-nav-shortcut-item">
				<span id="toggle-read">
					<span>Läs</span>
					<img src="assets/images/book.png" id="book" alt="">
					<?php if (!empty($newsRead)): ?>
					<div id="nr-read" class="nr-show"><?=count($newsRead); ?></div>
					<?php else: ?>
					<div id="nr-read" class="nr-hide"></div>
					<?php endif; ?>
				</span>
				<ul id="header-read" class="news">
					<?php if (!empty($newsRead)): ?>
					<?php foreach($newsRead as $n): ?>
					<li onclick="readNewsFeed(<?=$n['news_id']; ?>, '<?=$n['link']; ?>');">
						<div class="title"><?=$n['title']; ?></div>
						<div class="news-type"><?=$n['text']; ?></div>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="top-nav-shortcut-item">
				<span id="toggle-write">
					<span>Skriv</span>
					<img src="assets/images/pen-color.png" alt="">
					<?php if (!empty($newsWrite)): ?>
					<div id="nr-write" class="nr-show"><?=count($newsWrite); ?></div>
					<?php else: ?>
					<div id="nr-write" class="nr-hide"></div>
					<?php endif; ?>
				</span>
				<ul id="header-write" class="news">
					<?php if (!empty($newsWrite)): ?>
					<?php foreach($newsWrite as $n): ?>
					<li onclick="readNewsFeed(<?=$n['news_id']; ?>, '<?=$n['link']; ?>');">
						<div class="title"><?=$n['title']; ?></div>
						<div class="news-type"><?=$n['text']; ?></div>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="top-nav-shortcut-item">
				<span id="toggle-news">
					<span>Nyheter</span>
					<img src="assets/images/alert-big.png" id="alert" alt="">
					<?php if (!empty($news)): ?>
					<div id="nr-news" class="nr-show"><?=count($news); ?></div>
					<?php else: ?>
					<div id="nr-news" class="nr-hide"></div>
					<?php endif; ?>
				</span>
				<ul id="header-news" class="news">
					<?php if (!empty($news)): ?>
					<?php foreach($news as $n): ?>
					<li onclick="readNewsFeed(<?=$n['news_id']; ?>, '<?=$n['link']; ?>');">
						<div class="title"><?=$n['name']; ?></div>
						<div class="news-type"><?=$n['text']; ?></div>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div id="toggle-menu" class="top-nav-shortcut-item">
				<span>Meny</span>
				<img src="assets/images/menu.png" alt="">
			</div>
			<div id="hide-menu" style="display: none;" class="top-nav-shortcut-item">
				<span>Dölj</span>
				<img src="assets/images/arrow-up.png" alt="">
			</div>
		</div>
	</header>
	<nav id="nav" style="display: none;">
		<?php if (isset($_SESSION['user'])): ?>
		<ul style="float: left; margin-left: 20px; margin-right: 100px;">
			<li class="ul-title">Grupper</li>
			<?php if ($groups): ?>
				<?php foreach($groups as $group): ?>
				<li><a href="groups/<?=$group['id']; ?>/news"><?=$group['name']; ?></a></li>
				<?php endforeach; ?>
			<?php endif; ?>
			<hr />
			<li><a href="groups/new">Skapa ny</a></li>
			<li><a href="search?after=group">Sök</a></li>
		</ul>
		<ul style="float: left; margin-left: 20px; margin-right: 100px;">
			<li><a href="users/<?=$_SESSION['user']['id']; ?>">Profil</a></li>
			<li><a href="logout">Logga ut</a></li>
		</ul>
		<?php else: ?>
		<ul style="float: left; margin-left: 20px; margin-right: 100px;">
			<li><a href="login">Logga in</a></li>
			<li><a href="signup">Registrera</a></li>
		</ul>
		<ul>
			<li><a href="about">Om Great nonsens</a></li>
			<li><a href="cookies">Användning av cookies</a></li>
		</ul>
		<?php endif; ?>
	</nav>
	<div id="content">
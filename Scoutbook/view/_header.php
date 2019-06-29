<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Be prepared!</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Fresca|Noto+Sans+HK&display=swap" rel="stylesheet">
</head>
<body>
	<div id="username_logout">
		<h2 id="title">SCOUTBOOK</h2>
		<h3 id="username"><?php echo ucfirst($_SESSION["username"]); ?></h3>
		<a id="logout" href="scoutbook.php?rt=login/logout">Logout</a>
	</div>
	<nav>
		<ul>
			<li><a href="scoutbook.php?rt=troop/profile">Profil</a></li>
			<li><a href="scoutbook.php?rt=troop">Odred</a></li>
			<li><a href="scoutbook.php?rt=troop/patrol">Patrola</a></li>
			<li><a href="scoutbook.php?rt=troop/activities">Aktivnosti</a></li>
			<li><a href="scoutbook.php?rt=troop/myactivities">Moje Aktivnosti</a></li>
			<li><a href="scoutbook.php?rt=troop/newactivity">Napravi novu aktivnost</a></li>
		</ul>
	</nav>

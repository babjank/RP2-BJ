<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Be prepared!</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link type="text/css" rel="stylesheet" href="./css/calendar.css?newversion">
	<link href="https://fonts.googleapis.com/css?family=Fresca|Noto+Sans+HK&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css" type="text/css">
	<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<script src='scripts/header.js'></script>
	<div id="username_logout">
		<h2 id="title">SCOUTBOOK</h2>
		<img src="./data/scout.png" height="70px">
		<h3 id="username"><?php echo ucfirst($_SESSION["username"]); ?></h3>
		<a id="logout" href="scoutbook.php?rt=login/logout">Logout</a>
	</div>
	<?php
	// Navigacija s listom pomoću koje možemo birati što u aplikaciji želimo vidjeti; preusmjerava nas se na odgovarajuće stranice ovisno o našem odabiru
	?>
	<nav>
		<ul id="nav">
			<li><a class="nav" id="obavijesti" href="scoutbook.php?rt=troop/news">Obavijesti</a></li>
			<li><a class="nav" id="profil" href="scoutbook.php?rt=profil&username=
			<?php echo $_SESSION['username'];?>">Moj profil</a></li>
			<li><a class="nav" id="odred" href="scoutbook.php?rt=troop">Odred</a></li>
			<li><a class="nav" id="patrola" href="scoutbook.php?rt=troop/patrol">Patrola</a></li>
			<li><a class="nav" id="aktivnosti" href="scoutbook.php?rt=troop/activities">Aktivnosti</a></li>
			<li><a class="nav" id="mojeAktivnosti" href="scoutbook.php?rt=troop/myactivities">Moje Aktivnosti</a></li>
			<?php if ($_SESSION["voda"]) { ?>
			<li><a class="nav" id="novaAktivnost" href="scoutbook.php?rt=troop/newactivity">Napravi novu aktivnost</a></li>
			<li><a class="nav" id="noviIzvidac" href="scoutbook.php?rt=troop/newmember">Dodaj novog izviđača</a></li>
			<?php } ?>
		</ul>
	</nav>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>TeamUp App</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
</head>
<body>
	<div id="username_logout">
		<h2 id="teamup">TeamUp!</h2>
		<h3 id="username"><?php echo ucfirst($_SESSION["username"]); ?></h3>
		<a id="logout" href="teamup.php?rt=login/logout">Logout</a>
	</div>
	<nav>
		<ul>
			<li><a href="teamup.php?rt=project">All projects</a></li>
			<li><a href="teamup.php?rt=project/myprojects">My projects</a></li>
			<li><a href="teamup.php?rt=project/newproject">Start a new project</a></li>
			<li><a href="teamup.php?rt=project/invitations">Pending invitations</a></li>
			<li><a href="teamup.php?rt=project/applications">Pending applications</a></li>
		</ul>
	</nav>
	
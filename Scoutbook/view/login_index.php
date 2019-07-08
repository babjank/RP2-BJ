<?php require_once "view/_loginHeader.php";

if (isset($message))
	echo "<div id='errorMsg'>" . $message . " Pokušajte ponovno.</div><br>"; ?>

<form id="loginForm" method="post" action="scoutbook.php?rt=login/authentication">
	<span class="col-30">Korisničko ime: </span>
	<input class="col-70" type="text" name="username"><br>
	<span class="col-30">Password: </span>
	<input class="col-70" type="password" name="password"><br>
	<button type="submit" name="signin">Sign in!</button>
</form>

<?php require_once "view/_footer.php"; ?>

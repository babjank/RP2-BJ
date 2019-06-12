<?php require_once "view/_loginHeader.php"; 

if (isset($message))
	echo $message . " Pokušajte ponovno.<br><br>"; ?>

<form method="post" action="teamup.php?rt=login/authentication">
	Korisničko ime:
	<input type="text" name="username"><br>
	Password:
	<input type="password" name="password"><br>
	<button type="submit" name="signin">Sign in!</button>
	<button type="submit" name="signup">Sign up!</button>
</form>

<?php require_once "view/_footer.php"; ?>
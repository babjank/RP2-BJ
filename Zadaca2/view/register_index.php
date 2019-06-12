<?php require_once "view/_loginHeader.php";

if (isset($message))
	echo $message . " Pokušajte ponovno.<br><br>"; ?>

<form method="post" action="teamup.php?rt=login/register">
	Odaberite korisničko ime:
	<input type="text" name="username"><br>
	Odaberite password:
	<input type="password" name="password"><br>
	Vaša e-mail adresa:
	<input type="text" name="email"><br>
	<button type="submit">Stvori korisnički račun!</button>
</form>

<p>
	Povratak na <a href="teamup.php">početnu stranicu</a>.
</p>

<?php require_once "view/_footer.php"; ?>
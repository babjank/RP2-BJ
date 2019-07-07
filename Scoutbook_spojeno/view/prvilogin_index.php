<?php require_once "view/_prviloginHeader.php";

if (isset($message))
	echo $message . " Pokušajte ponovno.<br><br>"; ?>

<form method="post" action="scoutbook.php?rt=login/promijeniPodatke" enctype="multipart/form-data">
	Korisničko ime:
	<input type="text" name="username"><br>
	Password:
	<input type="password" name="password"><br>
	Ponovno upiši password:
	<input type="password" name="password2"><br>
	Uploadajte profilnu sliku:
    <input type="file" name="fileToUpload"><br>
	<button type="submit" name="signin">Sign in!</button>
</form>

<?php require_once "view/_footer.php"; ?>

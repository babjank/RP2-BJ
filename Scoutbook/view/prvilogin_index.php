<?php require_once "view/_prviloginHeader.php";

if (isset($message))
	echo "<div id='errorMsg'>" . $message . " Pokušajte ponovno.</div><br>"; ?>

<form id="prviloginForm" method="post" action="scoutbook.php?rt=login/promijeniPodatke"
	enctype="multipart/form-data">
	<span class="col-30">Korisničko ime: </span>
	<input class="col-70" type="text" name="username"><br>
	<span class="col-30">Password: </span>
	<input class="col-70" type="password" name="password"><br>
	<span class="col-30">Ponovno upiši password: </span>
	<input class="col-70" type="password" name="password2"><br>
	<span class="col-30">Uploadaj profilnu sliku: </span>
    <input class="col-70" type="file" name="fileToUpload"><br>
	<button type="submit" name="signin">Sign in!</button>
</form>

<?php require_once "view/_footer.php"; ?>

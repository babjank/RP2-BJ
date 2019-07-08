<?php require_once "view/_header.php";

if (isset($errorMsg)) {
	if (strcmp($errorMsg, "OK") === 0)
		echo "<div id='errorMsg'>Akcija je uspjela!</div><br>";

	else if (strcmp($errorMsg, "NOT_SET") === 0)
		echo "<div id='errorMsg'>Akcija nije uspjela, niste unijeli tražene podatke!</div><br>";

	else
		echo "<div id='errorMsg'>Akcija nije uspjela. Greška: " . $errorMsg . "</div><br>";
} ?>

<form id="newMemberForm" action="scoutbook.php?rt=troop/newmemberinput" method="POST">
	<span class="col-30">OIB: </span><input type="text" name="oib" class="col-70"><br>
	<span class="col-30">Ime: </span><input type="text" name="ime" class="col-70"><br>
	<span class="col-30">Prezime: </span><input type="text" name="prezime" class="col-70"><br>
	<span class="col-30">Adresa: </span><input type="text" name="adresa" class="col-70"><br>
	<span class="col-30">e-mail: </span><input type="text" name="email" class="col-70"><br>
	<button type="submit">Dodaj novog izviđača!</button>
</form>

<?php require_once "view/_footer.php"; ?>

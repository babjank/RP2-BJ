<?php require_once "view/_header.php";

if (isset($errorMsg)) {
	if (strcmp($errorMsg, "OK") === 0)
		echo "Akcija je uspjela!<br>";

	else if (strcmp($errorMsg, "NOT_SET") === 0)
		echo "Akcija nije uspjela, niste unijeli tražene podatke!<br>";

	else
		echo "Akcija nije uspjela. Greška: <br>" . $errorMsg . "<br>";
} ?>

<form action="scoutbook.php?rt=troop/newmemberinput" method="POST">
	OIB: <input type="text" name="oib"><br>
	Ime: <input type="text" name="ime"><br>
	Prezime: <input type="date" name="prezime"><br>
	Adresa: <input type="text" name="adresa"><br>
	e-mail: <input type="text" name="email"><br>
	<button type="submit">Dodaj novog izviđača!</button>
</form>

<?php require_once "view/_footer.php"; ?>
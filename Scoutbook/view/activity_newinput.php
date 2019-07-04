<?php require_once "view/_header.php";

if (strcmp($errorMsg, "OK") === 0) {
	echo "Akcija je uspjela!<br>";
	echo "<a href='scoutbook.php?rt=troop/showmine&id_aktivnost=" . $id_aktivnost . "'>Odvedi me na opis aktivnosti!</a>";
}

else if (strcmp($errorMsg, "NOT_SET") === 0)
	echo "Akcija nije uspjela, niste unijeli tražene podatke!<br>";

else
	echo "Akcija nije uspjela. Greška: <br>" . $errorMsg . "<br>";

require_once "view/_footer.php"; ?>

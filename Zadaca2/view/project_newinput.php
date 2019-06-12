<?php require_once "view/_header.php";

if (strcmp($errorMsg, "OK") === 0) {
	echo "Akcija je uspjela, unijeli ste novi projekt!<br>";
	echo "<a href='teamup.php?rt=project/showmine&id_project=" . $id_project . "'>Odvedi me na stranicu projekta!</a>";
}

else if (strcmp($errorMsg, "NOT_SET") === 0)
	echo "Akcija nije uspjela, niste unijeli tražene podatke!<br>";

else
	echo "Akcija nije uspjela. Greška: <br>" . $errorMsg . "<br>";

require_once "view/_footer.php"; ?>
<?php require_once "view/_header.php";

if (strcmp($errorMsg, "OK") === 0)
	echo "Akcija je uspjela!<br>";

else
	echo "Akcija nije uspjela. Greška: <br>" . $errorMsg . "<br>";

if ($byUser)
	echo "<a href='teamup.php?rt=project/showmine&id_project=" . $id_project . "'>Vrati me natrag na stranicu projekta!</a>";
else
	echo "<a href='teamup.php?rt=project/show&id_project=" . $id_project . "'>Odvedi me na stranicu projekta!</a>";

require_once "view/_footer.php"; ?>
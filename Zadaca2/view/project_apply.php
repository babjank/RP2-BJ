<?php require_once "view/_header.php";

if (strcmp($errorMsg, "OK") === 0)
	echo "Akcija je uspjela, prijavili ste se za projekt!<br>";

else
	echo "Akcija nije uspjela. Greška: <br>" . $errorMsg . "<br>";
	
echo "<a href='teamup.php?rt=project/show&id_project=" . $id_project . "'>Vrati me natrag na stranicu projekta!</a>";

require_once "view/_footer.php"; ?>
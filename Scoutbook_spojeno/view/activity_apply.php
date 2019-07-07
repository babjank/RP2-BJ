<?php require_once "view/_header.php";

if (strcmp($errorMsg, "OK") === 0)
	echo "Prijavljeni ste na izlet! U slučaju promjene javite se vođi patrole.<br>";

else
	echo "Akcija prijave nije uspjela. Greška: <br>" . $errorMsg . "<br>";

echo "<a href='scoutbook.php?rt=troop/myactivities'>Pogledaj na što svi sve prijavljen!</a>";

require_once "view/_footer.php"; ?>

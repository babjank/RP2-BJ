<?php require_once "view/_header.php";

if (strcmp($errorMsg, "OK") === 0)
	echo "<div id='errorMsg'>Prijavljeni ste na izlet! U slučaju promjene javite se vođi patrole.<br>";

else
	echo "<div id='errorMsg'>Akcija prijave nije uspjela. Greška: " . $errorMsg . "<br>";

echo "<a href='scoutbook.php?rt=troop/myactivities'>Pogledaj na što sve si prijavljen/a!</a></div>";

echo "<script>sessionStorage.setItem('aktivan', 'mojeAktivnosti')</script>";

require_once "view/_footer.php"; ?>

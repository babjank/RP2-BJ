<?php require_once "view/_header.php"; ?>

<?php
	echo "<h1>" . ucfirst($izvidac->username) . "</h1>";
	if ($izvidac->slika)
		echo "<img src='uploads/" . $izvidac->slika . "' height='200'><br>";
	echo "<div>";
	echo "Ime: " . $izvidac->ime . "<br>";
	echo "Prezime: " . $izvidac->prezime . "<br>";
	echo "e-mail: " . $izvidac->email . "<br>";
	echo "Patrola: " . $patrola->ime . "<br>";
	echo "Stupanj znanja: ";
	if (strcmp($patrola->stupanj, "zlatni") === 0)
		$stupanj = "gold";
	else if (strcmp($patrola->stupanj, "srebrni") === 0)
		$stupanj = "silver";
	else
		$stupanj = "bronze";
	echo "<img src='data/" . $stupanj . ".png' height='50'><br>";
?>	

<?php require_once "view/_footer.php"; ?>

<?php require_once "view/_header.php"; ?>

<?php
	echo "<h1>" . ucfirst($izvidac->username) . "</h1>";
	if ($_SESSION["voda"])
		echo "<img src='data/leadermedal.png' height='100'><br>";
	if ($izvidac->slika)
		echo "<img src='uploads/" . $izvidac->slika . "' height='200'><br>";
	echo "<div>";
	echo "Ime: " . $izvidac->ime . "<br>";
	echo "Prezime: " . $izvidac->prezime . "<br>";
	echo "e-mail: " . $izvidac->email . "<br>";
	echo "Patrola: " . $patrola . "<br>";
	if (!$_SESSION["voda"]) {
		echo "Stupanj znanja: ";
		if (strcmp($patrola->stupanj, "zlatni") === 0)
			$stupanj = "gold";
		else if (strcmp($patrola->stupanj, "srebrni") === 0)
			$stupanj = "silver";
		else
			$stupanj = "bronze";
		echo "<img src='data/" . $stupanj . ".png' height='50'><br>";
	}
	echo "</div>";
?>	

<?php require_once "view/_footer.php"; ?>

<?php require_once "view/_header.php"; ?>

<?php
	echo "<div>" . "Vođa: " . ucfirst($voda) ."<br>";
	echo "<h4>" . $aktivnost->datum_odrzavanja . "</h4>";
	echo "<h4>" . $aktivnost->mjesto . "</h4>";
	echo "<h4>" . $aktivnost->opis . "</h4>";
	echo "</div>";
?>

<?php require_once "view/_footer.php"; ?>

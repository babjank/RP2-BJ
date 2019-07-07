<?php require_once "view/_header.php"; ?>

<?php
	echo "<div>" . "Vođa: " . ucfirst($voda) ."<br>";
	echo "<h4>" . $aktivnost->mjesto . "</h4>";
	echo "<h5> Datum održavanja: </h5>" . $aktivnost->datum . "<br>";
	echo "<h5> Opis aktivnosti: </h5>" . $aktivnost->opis . "<br>";
	echo "</div>";

	echo "<div id='lokacija'></div>";
	echo "<div id='mapa'></div> <hl>";

	if($mine){
		echo "<h5>Dosada prijavljeni su: </h5> <ul id='popis'>";
		foreach ($izvidacList as $izvidac) {
			echo "<li>" . ucfirst($izvidac) . "</li>";
		}
		echo "</ul>";
	}
?>

<script src='./scripts/map.js'></script>

<?php require_once "view/_footer.php"; ?>

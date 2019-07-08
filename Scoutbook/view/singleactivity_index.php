<?php require_once "view/_header.php"; ?>

<?php
	echo "<div id='prikazAktivnosti'>" . "<span class='kategorija'>VOĐA: </span><a href='scoutbook.php?rt=profil&username=" . $voda . "'>" . ucfirst($voda)
		 . "</a><br>";
	echo "<h4>" . $aktivnost->mjesto . "</h4>";
	echo "<span class='kategorija'>DATUM ODRŽAVANJA: </span>" . $aktivnost->datum . "<br>";
	echo "<span class='kategorija'>OPIS AKTIVNOSTI: </span>" . $aktivnost->opis . "<br>";

	echo "<div id='lokacija'></div>";
	echo "<div id='mapa'></div>";

	if ($mine){
		echo "<span class='kategorija'>DO SADA SU PRIJAVLJENI: </span> <ul id='popis'>";
		foreach ($izvidacList as $izvidac) {
			echo "<li><a href='scoutbook.php?rt=profil&username=" . $izvidac .
				"'>" . ucfirst($izvidac) . "</a></li>";
		}
		echo "</ul>";
	}
?>

<script src='./scripts/map.js?newversion'></script>

</div>

<?php require_once "view/_footer.php"; ?>

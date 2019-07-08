<?php require_once "view/_header.php";

// Prikazujemo podatke o odgovarajućoj aktivnosti, ponovno klikom na ime vođe možemo vidjeti njegov profil
echo "<div id='prikazAktivnosti'>" . 
	"<span class='kategorija'>VOĐA: </span><a href='scoutbook.php?rt=profil&username=" . 
	$voda . "'>" . ucfirst($voda) . "</a><br>";
echo "<h4>" . $aktivnost->mjesto . "</h4>";
if ($aktivnost->datum < date("Y-m-d")) echo "<h2>Aktivnost je prošla.</h2>";
echo "<span class='kategorija'>DATUM ODRŽAVANJA: </span>" . $aktivnost->datum . "<br>" 
	. "<span class='kategorija'>OPIS AKTIVNOSTI: </span>" . $aktivnost->opis . "<br>";
echo "<span class='kategorija'>CIJENA AKTIVNOSTI: </span>" . $aktivnost->cijena . " kn <br>";

echo "(za sada prijavljeno: " . $aktivnost->broj_clanova . " članova)<br>";

echo "<div id='lokacija'></div>";
echo "<div id='mapa'></div>";

// Korisnici koji još nisu prijavljeni na danu aktivnost, nisu vođe mogu se prijaviti na tu aktivnost, ako nije već prošla
if (!$isaMember && !$_SESSION["voda"] && ($aktivnost->datum > date("Y-m-d"))) {
	echo "<form action='scoutbook.php?rt=troop/apply&id_aktivnost=" . $aktivnost->id . "' method='POST'>";
	echo "<button type='submit'>Prijavi se na izlet!</button>";
	echo "</form>";
}
?>

<script src='./scripts/map.js?newversion'></script>

</div>

<?php
require_once "view/_footer.php"; ?>
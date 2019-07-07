<?php require_once "view/_header.php";

echo "<div> <h4> Vođa: " . ucfirst($voda) . "</h4>";
echo "<h3>" . $aktivnost->mjesto . "</h3>";
if($aktivnost->datum < date("Y-m-d")) echo "<h2>Aktivnost je prošla.</h2>";
echo "<h5> Održava se: </h5>" . $aktivnost->datum . "<h5>Opis aktivnosti:</h5>";
echo $aktivnost->opis;
echo "<h5>Cijena aktivnosti: </h5>" . $aktivnost->cijena . " kn <br>";

echo "(za sada prijavljeno: " . $aktivnost->broj_clanova . " članova)<br>";

echo "<div id='lokacija'></div>";
echo "<div id='mapa'></div>";

if (!$isaMember && !$_SESSION["voda"] && ($aktivnost->datum > date("Y-m-d"))) {
	echo "<form action='scoutbook.php?rt=troop/apply&id_aktivnost=" . $aktivnost->id . "' method='POST'>";
	echo "<button type='submit'>Prijavi se na izlet!</button>";
	echo "</form>";
}
echo "</div>"; ?>

<script src='./scripts/map.js'></script>

<?php
require_once "view/_footer.php"; ?>

<?php require_once "view/_header.php"; ?>

<form action="scoutbook.php?rt=troop/newactivityinput" method="POST">
	Mjesto: <input type="text" name="mjesto"><br>
	Koordinate: <input type="text" name="sirina"> širina <input type="text" name="duzina"> dužina <br>
	Datum: <input type="date" name="datum"><br>
	Cijena: <input type="text" name="cijena"><br>
	Opis: <br><textarea name="abstract" rows="5" cols="50">Što uključuje aktivnost...</textarea><br>
	<button type="submit">Objavi novu aktivnost!</button>
</form>

<?php require_once "view/_footer.php"; ?>

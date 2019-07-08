<?php require_once "view/_header.php"; ?>

<form id='novaAktivnostForm' action="scoutbook.php?rt=troop/newactivityinput" method="POST">
	<span class="col-30">Mjesto: </span><input type="text" name="mjesto" class="col-70"><br>
	<span class="col-30">Geografska širina: </span><input type="text" name="sirina" class="col-70"><br> 
	<span class="col-30">Geografska dužina: </span><input type="text" name="duzina" class="col-70">
	<span class="col-30">Datum: </span><input type="date" name="datum" class="col-70"><br>
	<span class="col-30">Cijena: </span><input type="text" name="cijena" class="col-70"><br>
	<span class="col-30">Opis: </span><textarea name="abstract" rows="5" cols="50" class="col-70">Što uključuje aktivnost...</textarea><br>
	<button type="submit">Objavi novu aktivnost!</button>
</form>

<?php require_once "view/_footer.php"; ?>

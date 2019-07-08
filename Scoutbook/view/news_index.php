<?php require_once "view/_header.php"; 

// Ako je trenutno ulogirani korisnik vođa, može vidjeti formu za unos nove obavijesti. Ostatak vezan uz prikaz sadržaja obavlja skripta obavijesti.js (dohvaća i prikazuje obavijesti, komentare,...)
?>

<div id="newsArea"></div><br><br>

<?php if ($voda) {?>
<form id="novaObjavaForm" method="post" action="scoutbook.php?rt=troop/newNotification">
	Naslov:
	<input type="text" name="naslov"><br>
	Tekst objave:<br>
	<textarea name="objava" rows="10" cols="100"></textarea><br>
	<button type="submit" id="objavi">Objavi!</button>
</form>
<?php } ?>

<script src="./scripts/obavijesti.js"></script>

<?php require_once "view/_footer.php"; ?>
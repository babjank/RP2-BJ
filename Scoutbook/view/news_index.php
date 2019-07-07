<?php require_once "view/_header.php"; ?>

<div id="newsArea"></div><br><br>

<?php if ($voda) {?>
<form method="post" action="scoutbook.php?rt=troop/newNotification">
	Naslov:
	<input type="text" name="naslov"><br>
	Tekst objave:<br>
	<textarea name="objava" rows="10" cols="100"></textarea><br>
	<button type="submit" id="objavi">Objavi!</button>
</form>
<?php } ?>

<script src="./scripts/obavijesti.js?"></script>

<?php require_once "view/_footer.php"; ?>
<?php require_once "view/_header.php"; ?>

<form action="teamup.php?rt=project/newprojectinput" method="POST">
	Naslov: <input type="text" name="title"><br>
	Opis: <br><textarea name="abstract" rows="5" cols="50">Opišite projekt...</textarea><br>
	Ciljani broj članova: <input type="text" name="number_of_members"><br>
	<button type="submit">Unesi novi projekt!</button>
</form>

<?php require_once "view/_footer.php"; ?>
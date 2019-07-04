<?php require_once "view/_header.php"; ?>

<?php
	foreach($patrolaList as $patrola)
	{
		echo "<div>";
		echo "<h4>";
		if (strcmp($izvidac->ime_patrole, $patrola->ime) === 0)
			echo "<span style='background-color:#FFFFBF'>";
		if ($izvidac->ime_patrole === $patrola->ime)
			echo "<a href='scoutbook.php?rt=troop/showmine&id_patrola=". $patrola->ime . "'>" . $patrola->ime . "</a>";
		else
			echo "<a href='scoutbook.php?rt=troop/show&id_patrola=". $patrola->ime . "'>" . $patrola->ime . "</a>";
		if (strcmp($izvidac->ime_patrole, $patrola->ime) === 0)
			echo "</span>";
		echo "</h4>";
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>

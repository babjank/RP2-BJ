<?php require_once "view/_header.php"; ?>

<?php
	foreach($aktivnostList as $aktivnost)
	{
		$izvidac = $izvidacList[$aktivnost->id_izvidac];
		echo "<div>" . "Vođa: " . ucfirst($izvidac) ."<br>";
		echo "<h4>";
		if ($byUser && (strcmp($aktivnost->id_izvidac, $_SESSION["id"]) === 0))
			echo "<span style='background-color:#FFFFBF'>";
		if ($byUser)
			echo "<a href='scoutbook.php?rt=troop/showmine&id_aktivnost=". $aktivnost->id . "'>" . $aktivnost->mjesto . "</a>";
		else
			echo "<a href='scoutbook.php?rt=troop/show&id_aktivnost=". $aktivnost->id . "'>" . $aktivnost->mjesto . "</a>";
		if ($byUser && (strcmp($aktivnost->id_izvidac, $_SESSION["id"]) === 0))
			echo "</span>";
		echo "</h4>";
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>

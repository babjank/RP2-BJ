<?php require_once "view/_header.php"; ?>

<?php
	foreach($aktivnostList as $aktivnost)
	{
		$izvidac = $izvidacList[$aktivnost->id_izvidac];
		echo '<div class="aktivnost" id="div_'.$aktivnost->id.'">' . 'Vođa: ' . ucfirst($izvidac) .'<br>';
		echo "<h4>";
		if ($byUser && (strcmp($aktivnost->id_izvidac, $_SESSION["id"]) === 0))
			echo "<span style='background-color:#E6E6E6'>";
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

<hr>
	<div class="calendar-body">
		<div class="calendar-header">
			<span id="calendar-month-year-1"></span>
    </div>
    <div id="calendar-dates-1">
    </div>
  </div>

	<div class="calendar-body">
		<div class="calendar-header">
			<span id="calendar-month-year-2"></span>
    </div>
    <div id="calendar-dates-2">
    </div>
  </div>

<?php
if ($byUser) echo "<script src='./scripts/mycalendar.js'></script>";
else  echo "<script src='./scripts/calendar.js'></script>";
 ?>


<?php require_once "view/_footer.php"; ?>

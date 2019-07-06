<?php require_once "view/_header.php"; ?>

<?php
	foreach($izvidaci as $izvidac)
	{
		echo "<div>";
		if ($izvidac->slika) { 
			$slika_path = "uploads/" . $izvidac->slika; ?>
			<div style="background-image: url('<?php echo $slika_path; ?>'); width: 80px;
			height: 80px; background-position: center; background-size: cover; border-radius: 40%;"></div>
		<?php }
		echo "<a href='scoutbook.php?rt=profil&username=" . $izvidac->username . "'>" .
		 ucfirst($izvidac->username) . "</a>";
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>
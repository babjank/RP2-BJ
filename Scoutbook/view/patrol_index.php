<?php require_once "view/_header.php"; ?>

<?php
	/*
	Prikazujemo sve članove odgovarajuće patrole, odnosno njihova korisnička imena, zajedno s profilnim slikama
	(ako ih imaju, tj. ako su se nekada ulogirali u aplikaciju).
	Ako postoje poruke u razgovoru s danim korisnikom koje trenutno ulogirani korisnik još nije pročitao,
	o tome ga se obavještava slikom pored korisničkog imena odgovarajućeg korisnika. 
	Klikom na korisničko ime nekog od korisnika, trenutno ulogirani korisnik može vidjeti njihov profil te
	s njima komunicirati (prikazuje se i element div s podacima o samom ulogiranom korisniku, ali sam sa sobom
	ne može razgovarati).
	*/
	foreach($izvidaci as $izvidac)
	{
		echo "<div class='patrolMember' id='patrol" . $izvidac->username . "'>";
		if ($izvidac->slika) { 
			$slika_path = "uploads/" . $izvidac->slika; ?>
			<div style="background-image: url('<?php echo $slika_path; ?>'); width: 70px;
			height: 70px; background-position: center; background-size: cover; border-radius: 40%;"></div>
		<?php }
		echo "<a href='scoutbook.php?rt=profil&username=" . $izvidac->username . "'>" .
		 ucfirst($izvidac->username) . "</a>";
		 if (strcmp($izvidac->username, $_SESSION["username"]) !== 0) { ?>
		 <script>
		$(document).ready(function()
		{
			var username1 = "<?php echo $_SESSION['username'];?>";
			var username2 = "<?php echo $izvidac->username;?>";

			// Upit kojim se provjerava postoje li nepročitane poruke od danog korisnika i, ako postoje, to se prikazuje postavljanjem posebne slike pokraj korisničkog imena tog korisnika
			$.ajax(
			{
				url: "scoutbook.php?rt=ajax/newMessage",
				data: {username2: username2},
				type: "GET",
				dataType: "json",
				success: function(data)
				{
					var state = data.state;
					var procitano = data.procitano;
					if (state && state > procitano)
						$("#patrol" + username2).append("<img class='newMessageIcon' src='./data/newmessage.png' height='50' style='float:right; margin-right:20px; vertical-align:middle;'>");
				}
			});
		});		
		</script>
		<script src="./scripts/profil.js"></script>
		 <?php }
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>
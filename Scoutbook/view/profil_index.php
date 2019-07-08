<?php require_once "view/_header.php"; ?>

<?php
	// Ispisuju se osnovni podaci o danom korisniku
	echo "<div class='profilKorisnika'>";
	echo "<h1>" . ucfirst($izvidac->username);
	if ($voda) // Ako prikazujemo profil korisnika koji je vođa, to naglašavamo posebnom slikom koja implicira da se radi o vođi
		echo "<img id='leaderMedal' src='data/leadermedal.png' height='100' align='middle'>";
	echo "</h1>";
	if ($izvidac->slika) // Ako korisnik ima profilnu sliku, tj. ako se nekad ulogirao u aplikaciju, prikazuje se njegova slika
		echo "<img class='profilnaSlika' src='uploads/" . $izvidac->slika . "'><br>";
	echo "<div id='" . $izvidac->username . "'>";
	echo "<span class='kategorija'>IME: </span>" . $izvidac->ime . "<br>";
	echo "<span class='kategorija'>PREZIME: </span>" . $izvidac->prezime . "<br>";
	echo "<span class='kategorija'>E-MAIL: </span><a href='mailto:" .
	$izvidac->email . "' target='_top'>" . $izvidac->email . "</a><br>"; // Klik na e-mail adresu trenutno ulogiranom korisniku automatski omogućava slanje e-maila na tu adresu
	echo "<span class='kategorija'>PATROLA: </span>" . $ime_patrole . "<br>";
	if (!$voda) { // Za korisnike koji nisu vođe, prikazujemo njihov stupanj znanja (on može biti zlatni, srebrni i brončani)
		echo "<span class='kategorija'>STUPANJ ZNANJA: </span>";
		if (strcmp($patrola->stupanj, "zlatni") === 0)
			$stupanj = "gold";
		else if (strcmp($patrola->stupanj, "srebrni") === 0)
			$stupanj = "silver";
		else
			$stupanj = "bronze";
		echo "<img class='badgeImg' src='data/" . $stupanj . 
				".png' height='50' align='middle'><br>";
	}
	// Ako trenutno ulogirani korisnik gleda profil korisnika koji nije on (ne gleda svoj profil), može tom korisniku poslati poruku. Također, provjerava se ima li nepročitanih poruka od tog korisnika - ako ima, to se prikazuje odgovarajućom slikom
	if (strcmp($izvidac->username, $_SESSION["username"]) !== 0) { ?>
		<span class="posaljiPoruku">Pošalji poruku!</span><script>
		$(document).ready(function()
		{
			var username1 = "<?php echo $_SESSION['username'];?>";
			var username2 = "<?php echo $izvidac->username;?>";
			// Upit koji provjerava ima li nepročitanih poruka od danog korisnika
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
						$("#" + username2).append("<br><img class='newMessageIcon' src='./data/newmessage.png' height='50'>");
				}
			});
		});
	</script></div>
	<?php }

	if (strcmp($izvidac->username, $_SESSION["username"]) !== 0) { ?>
		<script src="./scripts/chat.js"></script>
		<script src="./scripts/profil.js"></script>
	<?php } ?></div>

<?php require_once "view/_footer.php"; ?>

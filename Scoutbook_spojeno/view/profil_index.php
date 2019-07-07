<?php require_once "view/_header.php"; ?>

<?php
	echo "<h1>" . ucfirst($izvidac->username) . "</h1>";
	if ($voda)
		echo "<img src='data/leadermedal.png' height='100'><br>";
	if ($izvidac->slika)
		echo "<img src='uploads/" . $izvidac->slika . "' height='200'><br>";
	echo "<div id='" . $izvidac->username . "'>";
	echo "Ime: " . $izvidac->ime . "<br>";
	echo "Prezime: " . $izvidac->prezime . "<br>";
	echo "e-mail: " . $izvidac->email . "<br>";
	echo "Patrola: " . $ime_patrole . "<br>";
	if (!$voda) {
		echo "Stupanj znanja: ";
		if (strcmp($patrola->stupanj, "zlatni") === 0)
			$stupanj = "gold";
		else if (strcmp($patrola->stupanj, "srebrni") === 0)
			$stupanj = "silver";
		else
			$stupanj = "bronze";
		echo "<img src='data/" . $stupanj . ".png' height='50'><br>";
	}
	if (strcmp($izvidac->username, $_SESSION["username"]) !== 0) { ?>
		<span class="posaljiPoruku">Pošalji poruku!</span><script>
		$(document).ready(function()
		{
			var username1 = "<?php echo $_SESSION['username'];?>";
			var username2 = "<?php echo $izvidac->username;?>";
			$.ajax(
			{
				url: "scoutbook.php?rt=ajax/newMessage",
				data: {username2: username2},
				type: "GET",
				dataType: "json",
				success: function(data)
				{
					var state = data.state;
					if (state && state > localStorage.getItem(username1 + "_" + username2))
						$("#" + username2).append("<br>New message!");
				}
			});
		});
	</script></div>
	<?php }

	if (strcmp($izvidac->username, $_SESSION["username"]) !== 0)?>
		<script src="./scripts/chat.js?newversion"></script>

<?php require_once "view/_footer.php"; ?>

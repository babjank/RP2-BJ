<?php require_once "view/_header.php"; ?>

<?php
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
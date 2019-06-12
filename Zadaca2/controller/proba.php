<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Zadatak 3</title>
	</head>
	<body>
		<?php
			echo "http://" . $_SERVER["SERVER_NAME"] . htmlentities(dirname($_SERVER["PHP_SELF"])) .
		"/../teamup.php?rt=login/confirmation<br>";
		?>
	</body>
</html>
<?php

class IndexController
{
	public function index()
	{
		// Samo preusmjeri na login podstranicu.
		if (!isset($_SESSION["username"]))
			header("Location: scoutbook.php?rt=login");
		else
			header("Location: scoutbook.php?rt=troop");
	}
};

?>

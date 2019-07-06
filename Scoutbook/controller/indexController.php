<?php

require_once "model/service.class.php";

class IndexController
{
	public function index()
	{
		// Samo preusmjeri na login podstranicu.
		$tus = new Service();
		
		$izvidac = $tus->getUserByUsername($_SESSION["username"]);
		if (!isset($_SESSION["username"])) {
			header("Location: scoutbook.php?rt=login");
			exit();
		} else {
			if (strcmp($izvidac->ulogiran, "1") === 0) {
				header("Location: scoutbook.php?rt=troop&prvi=true");
				exit();
			} else {
				header("Location: scoutbook.php?rt=login/prvilogin");
				exit();
			}
		}
	}
};

?>

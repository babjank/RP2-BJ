<?php

require_once "model/service.class.php";

class IndexController
{
	public function index()
	{
		$tus = new Service();
		
		$izvidac = $tus->getUserByUsername($_SESSION["username"]);
		if (!isset($_SESSION["username"])) { 
		// Ako korisnik nije ulogiran, preusmjerava ga se na stranicu s login formom
			header("Location: scoutbook.php?rt=login");
			exit();
		} else {
		// Ako korisnik jest ulogiran, preusmjerava ga se ili na stranicu s formom za unos preferiranih podataka (u slučaju da se ulogirao prvi put) ili na naslovnu stranicu aplikacije (odjeljak s obavijestima)
			if (strcmp($izvidac->ulogiran, "1") === 0) { 
				header("Location: scoutbook.php?rt=troop/news");
				exit();
			} else {
				header("Location: scoutbook.php?rt=login/prvilogin");
				exit();
			}
		}
	}
};

?>

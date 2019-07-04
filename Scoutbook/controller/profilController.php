<?php

require_once "model/service.class.php";

class ProfilController
{
	public function index()
	{
		$tus = new Service();
		
		$izvidac = $tus->getUserByUsername($_SESSION["username"]);
		$patrola = $tus->getTroopById($izvidac->ime_patrole);
		$aktivnostList = $tus->getAcitivtiesByMemberId($_SESSION["id"]);
		
		require_once "view/profil_index.php";
	}
};

?>
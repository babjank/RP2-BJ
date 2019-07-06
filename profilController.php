<?php

require_once "model/service.class.php";

class ProfilController
{
	public function index()
	{
		$tus = new Service();
		
		$izvidac = $tus->getUserByUsername($_SESSION["username"]);
		if (!$_SESSION["voda"])
			$patrola = $izvidac->ime_patrole;
		else
			$patrola = $tus->getLeadersPatrol($_SESSION["id"]);
		$aktivnostList = $tus->getAcitivtiesByMemberId($_SESSION["id"]);
		
		require_once "view/profil_index.php";
	}
};

?>
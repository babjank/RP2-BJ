<?php

require_once "model/service.class.php";

class ProfilController
{
	public function index()
	{
		$tus = new Service();
		
		$izvidac = $tus->getUserByUsername($_GET["username"]);
		$voda = $tus->checkIfLeaderByUsername($_GET["username"]);
		if (!$voda)
			$patrola = $izvidac->ime_patrole;
		else
			$patrola = $tus->getLeadersPatrol($tus->getUserByUsername($_GET["username"])->id);
		$aktivnostList = $tus->getAcitivtiesByMemberId($tus->getUserByUsername($_GET["username"])->id);
		
		require_once "view/profil_index.php";
	}
};

?>
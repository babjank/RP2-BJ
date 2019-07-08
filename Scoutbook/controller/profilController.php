<?php

require_once "model/service.class.php";

class ProfilController
{
	public function index()
	{
		$tus = new Service();

		$izvidac = $tus->getUserByUsername($_GET["username"]);
		$voda = $tus->checkIfLeaderByUsername($_GET["username"]);
		if (!$voda){
			$patrola = $tus->getTroopById($izvidac->ime_patrole);
			$ime_patrole = $patrola->ime_patrole;
		}
		else
			$ime_patrole = $tus->getLeadersPatrol($tus->getUserByUsername($_GET["username"])->id);
		$aktivnostList = $tus->getAcitivtiesByMemberId($tus->getUserByUsername($_GET["username"])->id);

		require_once "view/profil_index.php";
	}
};

?>

<?php

require_once "model/service.class.php";

class ProfilController
{
	public function index()
	{
		$tus = new Service();

		// Iz baze podataka dohvaćamo sve podatke koji su nam potrebni kako bismo prikazali profil odgovarajućeg korisnika (s profilnom slikom, imenom, prezimenom, e-mail adresom i sl.)
		$izvidac = $tus->getUserByUsername($_GET["username"]);
		$voda = $tus->checkIfLeaderByUsername($_GET["username"]);
		if (!$voda){ 
		/* Provjeravamo je li korisnik čiji profil želimo prikazati vođa ili ne.
		To činimo zato što postoji razlika u prikazima profila vođa i ostalih članova.
		Naime, za vođe se pored korisničkog imena prikazuje i dodatna slika koja nastoji naglasiti da se radi o vođi.
		S druge strane, za ostale se članove prikazuje stupanj znanja, koji se ne prikazuje za vođe.
		Također, ime patrole za vođe nije navedeno u samoj bazi podataka (za njih se smatra kako službeno nisu član niti jedne patrole). Njihovom se patrolom smatra ona patrola koju vode.
		*/
			$patrola = $tus->getTroopById($izvidac->ime_patrole);
			$ime_patrole = $patrola->ime_patrole;
		}
		else
			$ime_patrole = $tus->getLeadersPatrol($tus->getUserByUsername($_GET["username"])->id);

		require_once "view/profil_index.php";
	}
};

?>

<?php

require_once "model/service.class.php";

class TroopController
{
	public function index()
	{
		$tus = new Service();

		$patrolaList = $tus->getAllTroops();
		$izvidac = $tus->getUserByUsername($_SESSION["username"]);
		$byUser = false;
		require_once "view/troop_index.php";
	}

	public function activities()
	{
		$tus = new Service();

		$aktivnostList = $tus->getAllActivities();
		$izvidacList = [];

		foreach ($aktivnostList as $aktivnost) {
			$id = $aktivnost->id_izvidac;
			$izvidac = $tus->getUserById($id);
			$izvidacList[$id] = $izvidac->username;
		}

		$byUser = false;
		require_once "view/activity_index.php";
	}

	public function myactivities()
	{
		$tus = new Service();

		$aktivnostList = $tus->getAcitivtiesByMemberId($_SESSION["id"]);
		$izvidacList = [];

		foreach ($aktivnostList as $aktivnost) {
			$id = $aktivnost->id_izvidac;
			$izvidac = $tus->getUserById($id);
			$izvidacList[$id] = $izvidac->username;
		}

		$byUser = true;
		require_once "view/activity_index.php";
	}

	public function newactivity()
	{
		require_once "view/activity_new.php";
	}

	public function newactivityinput()
	{
		$tus = new Service();

		$errorMsg = "NOT_SET";

		if (isset($_POST["mjesto"]) && isset($_POST["datum"]) && isset($_POST["cijena"]) &&
		(strcmp($_POST["mjesto"], "") !== 0) && (strcmp($_POST["datum"], "") !== 0)) {
			$retVal = $tus->insertActivity($_SESSION["id"], $_POST["mjesto"], $_POST["datum"], $_POST["cijena"]);
			$errorMsg = $retVal[0];
			$id_aktivnost = $retVal[1];
		}

		require_once "view/activity_newinput.php";
	}
};

?>

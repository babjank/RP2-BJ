<?php

require_once "model/service.class.php";

class TroopController
{
	public function index()
	{
		$tus = new Service();

		$patrolaList = $tus->getAllTroops($false);
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
			$retVal = $tus->insertActivity($_SESSION["id"], $_POST["mjesto"], $_POST["datum"], $_POST["cijena"], $_POST["abstract"]);
			$errorMsg = $retVal[0];
			$id_aktivnost = $retVal[1];
		}

		require_once "view/activity_newinput.php";
	}
	
	public function newmember()
	{
		require_once "view/addnewmember.php";
	}
	
	public function newmemberinput()
	{
		$tus = new Service();
		
		$errorMsg = "NOT_SET";
		
		if (isset($_POST["oib"]) && isset($_POST["ime"]) && isset($_POST["prezime"]) && isset($_POST["adresa"]) 
		&& isset($_POST["email"]) && (strcmp($_POST["oib"], "") !== 0) && (strcmp($_POST["ime"], "") !== 0) 
		&& (strcmp($_POST["prezime"], "") !== 0) && (strcmp($_POST["adresa"], "") !== 0) 
		&& (strcmp($_POST["email"], "") !== 0)) {
			$patrola = $tus->getLeadersPatrol($_SESSION["id"]);
			$errorMsg = $tus->insertMember($_POST["oib"], $_POST["ime"], $_POST["prezime"], $_POST["adresa"], 
										$_POST["email"], $patrola);
		}
		
		require_once "view/addnewmember.php";
	}
	
	public function showmine()
	{
		$tus = new Service();
		
		$activityId = $_GET["id_aktivnost"];
		$aktivnost = $tus->getActivityById($activityId);
		$voda = $tus->getUserById($aktivnost->id_izvidac)->username;
		
		require_once "view/singleactivity_index.php";
	}
	
	public function patrol()
	{
		$tus = new Service();
		
		if (!$_SESSION["voda"])
			$patrola = $tus->getUserById($_SESSION["id"])->ime_patrole;
		else
			$patrola = $tus->getLeadersPatrol($_SESSION["id"]);
		$izvidaci = $tus->getUsersByPatrol($patrola);
		require_once "view/patrol_index.php";
	}
	
	public function news()
	{
		echo "<script>sessionStorage.setItem('aktivan', 'obavijesti')</script>";
	
		$voda = $_SESSION["voda"];
				
		require_once "view/news_index.php";
	}
	
	public function newNotification()
	{
		$sadrzaj = $_POST["objava"];
		$naslov = $_POST["naslov"];
		$datum = date("Y-m-d");
		
		$tus = new Service();
		$tus->insertNews($sadrzaj, $naslov, $datum, $_SESSION["id"]);
		
		header("Location: scoutbook.php?rt=troop/news");
		exit();
	}
};

?>

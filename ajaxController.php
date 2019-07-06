<?php

require_once "model/service.class.php";

function sendJSONandExit($message)
{
	header("Content-type:application/json;charset=utf-8");
	echo json_encode($message);
	flush();
	exit(0);
}

class ajaxController
{
	function index()
	{
		$tus = new Service();
		
		$patrolaList = $tus->getAllTroops(true);
		$vode = [];
		foreach ($patrolaList as $patrola)
			$vode[] = $tus->getPatrolsLeader($patrola["ime_patrole"]);
  		
		$message = [];
		$message["patrole"] = $patrolaList;
		$message["vode"] = $vode;

		sendJSONandExit($message);
	}
}
?>
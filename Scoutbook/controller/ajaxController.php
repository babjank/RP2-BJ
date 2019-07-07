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
	
	function chat()
	{
		$function = $_GET["function"];
		$log = array();
		$username1 = $_SESSION["username"];
		$username2 = $_GET["username2"];
		if (strcmp($username1, $username2) < 0)
			$filename = "./chats/" . $username1 . "_" . $username2 . ".txt";
		else
			$filename = "./chats/" . $username2 . "_" . $username1 . ".txt";
		
		switch ($function) {
			case ("getState"):
				if (file_exists($filename)) {
					$lines = file($filename);
					//$log["state"] = count($lines);
				} else {
					fopen($filename);
					$lines = file($filename);
				}
				$log["state"] = 0;
				break;
				
			case ("update"):
				$state = $_GET["state"];
				$lines = file($filename);
				$count = count($lines);
				if ($state == $count) {
					$log["state"] = $state;
					$log["text"] = false;
				} else {
					$text = array();
					$log["state"] = $state + count($lines) - $state;
					foreach ($lines as $line_num => $line) {
						if ($line_num >= $state) {
							$text[] = $line = str_replace("\n", "", $line);
						}
					}
					$log["text"] = $text;
				}
				break;
				
			case ("send"):
				$username2 = htmlentities(strip_tags($username2));
				$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
				$message = htmlentities(strip_tags($_GET["message"]));
				if (($message) != "\n") {
					if (preg_match($reg_exUrl, $message, $url)) {
						$message = preg_replace($reg_exUrl, 
						'<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
					}
					fwrite(fopen($filename, "a"), "<span>". 
					ucfirst($_SESSION["username"]) . ": </span>" . $message = str_replace("\n", " ", $message) . "\n"); 
				}
				break;
		}
		sendJSONandExit($log);
	}
	
	function news()
	{
		$tus = new Service();
		
		$objave = $tus->getNews();
		
		$message = [];
		$message["objave"] = $objave;
		sendJSONandExit($message);
	}
	
	function getState($username1, $username2)
	{
		if (strcmp($username1, $username2) < 0)
			$filename = "./chats/" . $username1 . "_" . $username2 . ".txt";
		else
			$filename = "./chats/" . $username2 . "_" . $username1 . ".txt";
		if (!file_exists($filename))
			return false;

		return count(file($filename));
	}
	
	function newMessage()
	{
		$username2 = $_GET["username2"];
		
		$state = $this->getState($_SESSION["username"], $username2);
		
		$message = [];
		$message["state"] = $state;
		sendJSONandExit($message);
	}
	
	function username()
	{
		$message = [];
		$message["username"] = $_SESSION["username"];
		sendJSONandExit($message);
	}
}
?>
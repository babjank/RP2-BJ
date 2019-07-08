<?php

require_once "model/service.class.php";

function sendJSONandExit($message)
{
	header("Content-type:application/json;charset=utf-8");
	echo json_encode($message);
	flush();
	exit(0);
}

// Klasa pomoću koje obrađujemo razne AJAX upite. Za svaku vrstu AJAX upita postoji odgovarajuća metoda
class ajaxController
{
	function troop()
	{
		// Obrađujemo upit koji šalje skripta troop.js, kojim traži popis svih patrola unutar odreda i detalja o njima
		$tus = new Service();

		$patrolaList = $tus->getAllTroops(true); // Argument true nalaže funkciji da vrati asocijativno polje, a ne objekt klase Troop
		$vode = []; // Za opis pojedine patrole, potreban nam je i njezin vođa
		foreach ($patrolaList as $patrola)
			$vode[] = $tus->getPatrolsLeader($patrola["ime_patrole"]);

		$message = [];
		$message["patrole"] = $patrolaList;
		$message["vode"] = $vode;

		sendJSONandExit($message);
	}

	function chat()
	{
		// Obrađujemo upite koje šalje skripta chat.js, a pomoću kojih se ostvaruje funkcionalnost chata
		$function = $_GET["function"];
		$log = array();
		$username1 = $_SESSION["username"];
		$username2 = $_GET["username2"];
		/* Razgovore među korisnicima spremamo u .txt datoteke. 
		Za svaki par korisnika, postoji jedna datoteka s pohranjenim njihovim razgovorom. 
		Njezin naziv dobivamo tako da konkateniramo leksički manje korisničko ime s _ 
		i leksički većim korisničkim imenom.
		*/
		if (strcmp($username1, $username2) < 0)
			$filename = "./chats/" . $username1 . "_" . $username2 . ".txt";
		else
			$filename = "./chats/" . $username2 . "_" . $username1 . ".txt";

		/* Moguće su tri vrijednosti varijable function.
		function = "getState" => stvaramo datoteku za pohranjivanje razgovora ako ona već ne postoji 
		function = "update" => ako ima novih poruka, šaljemo ih skripti da ih ispiše korisniku
		function = "send" => u odgovarajuću datoteku upisujemo nove poruke kao nove linije
		*/
		switch ($function) {
			case ("getState"):
				if (!file_exists($filename))
					fopen($filename, "w");
				$log["state"] = 0;
				break;

			case ("update"):
				$state = $_GET["state"];
				$lines = file($filename);
				$count = count($lines);
				if ($state == $count) {
					$log["state"] = $state;
					$log["text"] = false; // Nema novih poruka
				} else {
					$text = array();
					$log["state"] = $state + count($lines) - $state;
					foreach ($lines as $line_num => $line) {
						if ($line_num >= $state) {
							$text[] = $line = str_replace("\n", "", $line);
						}
					}
					$log["text"] = $text; // Ima novih poruka, šaljemo ih skripti da ih prikaže korisniku
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
					fwrite(fopen($filename, "a"), "<span>" .
					ucfirst($_SESSION["username"]) . ": </span>" . 
					$message = str_replace("\n", " ", $message) . "\n");
				}
				break;
		}
		sendJSONandExit($log);
	}

	function news()
	{
		// Obrađujemo upit koji šalje skripta obavijesti.js, kojim traži sve obavijesti pohranjene u bazi podataka
		$tus = new Service();

		$objave = $tus->getNews();

		$message = [];
		$message["objave"] = $objave;
		sendJSONandExit($message);
	}

	function getState($username1, $username2)
	{
		// Pomoćna funkcija kojom dohvaćamo broj linija u datoteci s pohranjenim razgovorom između osoba s korisničkim imenima username1 i username2 (ako ta datoteka ne postoji, vraćamo false)
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
		// Obrađujemo upit kojim skripte nastoje saznati postoje li od odgovarajućeg korisnika koje trenutno ulogirani korisnik nije pročitao
		$tus = new Service();
		
		$username2 = $_GET["username2"];

		$state = $this->getState($_SESSION["username"], $username2);
		$procitano = $tus->getReadMessages($_SESSION["id"], $tus->getUserByUsername($username2)->id);

		$message = [];
		$message["state"] = $state;
		$message["procitano"] = $procitano;
		// Saznajemo ima li novih poruka uspoređivanjem broja linija u odgovarajućoj datoteci i broja do sad pročitanih poruka od strane ulogiranog korisnika (iz razgovora s odgovarajućim korisnikom) iz baze podataka
		sendJSONandExit($message);
	}

	function username()
	{
		// Obrađujemo upit za korisničkim imenom trenutno ulogiranog korisnika
		$message = [];
		$message["username"] = $_SESSION["username"];
		sendJSONandExit($message);
	}

	function komentari()
	{
		// Obrađujemo upit koji šalje skripta obavijesti.js, a kojim nastoji dohvatiti sve komentare na zadanoj obavijesti
		$id_obavijest = $_GET["id_obavijest"]; // ID obavijesti čiji nas komentari zanimaju

		$tus = new Service();

		$komentari = $tus->getCommentsById($id_obavijest);
		$message = [];
		$message["komentari"] = $komentari;
		sendJSONandExit($message);
	}

	function sviKomentari()
	{
		// Obrađujemo upit koji šalje skripta obavijesti.js, a kojim nastoji dohvatiti sve komentare
		$tus = new Service();

		$komentari = $tus->getComments();
		$message = [];
		$message["komentari"] = $komentari;
		sendJSONandExit($message);
	}

	function calendar()
	{
		// Obrađujemo upite skripte calendar.js, a na koje odgovaramo slanjem svih aktivnosti
		$tus = new Service();
		$aktivnostList = $tus->getAllActivities();

		$message['datumi'] = [];
		$message['id'] = [];

		foreach ($aktivnostList as $aktivnost) {
			$message['datumi'][] = $aktivnost->datum;
			$message['id'][] = $aktivnost->id;
		}

		sendJSONandExit( $message );
	}

	function mycalendar()
	{
		// Obrađujemo upite skripte mycalendar.js, a na koje odgovaramo slanjem svih aktivnosti odgovarajućeg korisnika
		$tus = new Service();
		$aktivnostList = $tus->getAcitivtiesByMemberId($_SESSION["id"]);

		$message['datumi'] = [];
		$message['id'] = [];

		foreach ($aktivnostList as $aktivnost) {
			$message['datumi'][] = $aktivnost->datum;
			$message['id'][] = $aktivnost->id;
		}

		sendJSONandExit( $message );
	}

	function map()
	{
		// Obrađujemo upite skripte map.js, a na koje odgovaramo slanjem geografske širine i dužine aktivnosti sa zadnim IDjem
		$tus = new Service();

		$aktivnost = $tus->getActivityById($_SESSION["id_aktivnost"]);

		$message['sirina'] = $aktivnost->sirina;
		$message['duzina'] = $aktivnost->duzina;

		sendJSONandExit( $message );
	}
	
	function updateProcitano()
	{
		// Obrađujemo upit koji šalje skripta chat.js, a kojim ona traži da se osvježi broj pročitanih poruka odgovarajućeg korisnika od strane trenutno ulogiranog korisnika (kad updateamo chat, moramo i osvježiti taj broj)
		$tus = new Service();
	
		$oib1 = $tus->getUserByUsername($_GET["username1"])->id;
		$oib2 = $tus->getUserByUsername($_GET["username2"])->id;
		$state = $_GET["state"];
		
		$tus->updateReadMessages($oib1, $oib2, $state);
	}
}
?>

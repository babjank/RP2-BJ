<?php

require_once "db.class.php";
require_once "user.class.php";
require_once "troop.class.php";
require_once "activity.class.php";
require_once "member.class.php";

class Service
{
	function getUserByUsername($username)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM IZVIDAC WHERE USERNAME=:username");
			$st->execute(array("username" => $username));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new User($row["OIB"], $row["IME"], $row["PREZIME"], $row["ADRESA"],
							$row["DATUM_UPISA"], $row["IME_PATROLE"], $row["EMAIL"], $row["USERNAME"],
							$row["PASSWORD_HASH"], $row["ULOGIRAN"], $row["SLIKA"]);
	}

	function getUserById($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM IZVIDAC WHERE OIB=:id");
			$st->execute(array("id" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new User($row["OIB"], $row["IME"], $row["PREZIME"], $row["ADRESA"],
							$row["DATUM_UPISA"], $row["IME_PATROLE"], $row["EMAIL"], $row["USERNAME"],
							$row["PASSWORD_HASH"], $row["ULOGIRAN"], $row["SLIKA"]);
	}


	function getTroopById($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM PATROLA WHERE IME_PATROLE=:id");
			$st->execute(array("id" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new Troop($row["IME_PATROLE"], $row["RAZRED"], $row["STUPANJ_ZNANJA"], $row["ID_RADIONICA"]);
	}


	function getAllTroops($js)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM PATROLA");
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			if (!$js)
				$arr[] = new Troop($row["IME_PATROLE"], $row["RAZRED"], $row["STUPANJ_ZNANJA"], $row["ID_RADIONICA"]);
			else
				$arr[] = ["ime_patrole" => $row["IME_PATROLE"], "razred" => $row["RAZRED"],
				"stupanj_znanja" => $row["STUPANJ_ZNANJA"], "id_radionice" => $row["ID_RADIONICA"]];
		}

		return $arr;
	}

	function getActivityById($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM AKTIVNOST WHERE ID=:id");
			$st->execute(array("id" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new Activity($row["ID"], $row["OIB"], $row["DATUM_ODRZAVANJA"], $row["MJESTO"], $row["OPIS"], $row["CIJENA"], $row["BROJ_CLANOVA"], $row["SIRINA"], $row["DUZINA"]);
	}


	function getAllActivities()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM AKTIVNOST");
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			$arr[] = new Activity($row["ID"], $row["OIB"], $row["DATUM_ODRZAVANJA"], $row["MJESTO"], $row["OPIS"], $row["CIJENA"], $row["BROJ_CLANOVA"], $row["SIRINA"], $row["DUZINA"]);
		}

		return $arr;
	}

	function getAcitivtiesByMemberId($id_user)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM SUDJELUJE_NA WHERE OIB=:id_user");
			$st->execute(array("id_user" => $id_user));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			$activity = $this->getActivityById($row["ID_AKTIVNOST"]);
			$arr[] = new Activity($activity->id, $activity->id_izvidac, $activity->datum, $activity->mjesto,
			$activity->opis, $activity->cijena, $activity->broj_clanova, $activity->sirina, $activity->duzina);
		}

		return $arr;
	}

	function getMembersByActivityId($id_activity)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM SUDJELUJE_NA WHERE ID_AKTIVNOST=:id_activity");
			$st->execute(array("id_activity" => $id_activity));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = new Member($row["ID"], $row["ID_AKTIVNOST"], $row["OIB"], $row["ULOGA"]);

		return $arr;
	}


	function changeUserInfo($old_username, $username, $password, $slika)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("UPDATE IZVIDAC SET USERNAME=:username, PASSWORD_HASH=:password, ULOGIRAN=:ulogiran,
			 					SLIKA=:slika WHERE USERNAME=:old_username");
			$st->execute(array("old_username" => $old_username, "username" => $username,
							"password" => $password, "ulogiran" => 1, "slika" => $slika));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
	}

	function checkIfLeaderByID($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM VODA WHERE OIB=:oib");
			$st->execute(array("oib" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if ($row === false)
			return false;
		return true;
	}

	function checkIfLeaderByUsername($username)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM VODA,IZVIDAC WHERE VODA.OIB=IZVIDAC.OIB
								AND USERNAME=:username");
			$st->execute(array("username" => $username));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if ($row === false)
			return false;
		return true;
	}

	function insertMember($oib, $ime, $prezime, $adresa, $email, $ime_patrole)
	{
		$errorMsg = "OK";

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO IZVIDAC(OIB, IME, PREZIME, ADRESA, DATUM_UPISA,
			IME_PATROLE, EMAIL, USERNAME, PASSWORD_HASH, ULOGIRAN)
			VALUES (:oib, :ime, :prezime, :adresa, :datum_upisa, :ime_patrole,
			:email, :username, :password_hash, :ulogiran)");
			$st->execute(array("oib" => $oib, "ime" => $ime, "prezime" => $prezime, "adresa" => $adresa,
			"datum_upisa" => date("Y-m-d"), "ime_patrole" => $ime_patrole, "email" => $email,
			"username" => $oib, "password_hash" => password_hash(strtolower($ime_patrole), PASSWORD_DEFAULT),
			"ulogiran" => 0));
		}
		catch(PDOException $e) { $errorMsg = $e->getMessage(); }

		return $errorMsg;
	}

	function insertMemberOfActivity($id_activity, $id_user)
	{
		$errorMsg = 'OK';

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO SUDJELUJE_NA(ID_AKTIVNOST, OIB, ULOGA)
			 VALUES (:id_activity, :id_user, :uloga)");
			$st->execute(array("id_activity" => $id_activity, "id_user" => $id_user,
			"uloga" => "sudionik"));
		}
		catch(PDOException $e) { $errorMsg = $e->getMessage(); }
		
		if (strcmp($errorMsg, "OK") === 0) {
			$broj = ($this->getActivityById($id_activity))->broj_clanova + 1;
	
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare("UPDATE AKTIVNOST SET BROJ_CLANOVA=:broj_clanova WHERE ID=:id_activity");
				$st->execute(array("id_activity" => $id_activity, "broj_clanova" => $broj));
			}
			catch(PDOException $e) { $errorMsg = $e->getMessage(); }
		}

		if (strcmp($errorMsg, "OK") === 0) {
			$broj = ($this->getActivityById($id_activity))->broj_clanova + 1;

			try
			{
				$db = DB::getConnection();
				$st = $db->prepare("UPDATE AKTIVNOST SET BROJ_CLANOVA=:broj_clanova WHERE ID=:id_activity");
				$st->execute(array("id_activity" => $id_activity, "broj_clanova" => $broj));
			}
			catch(PDOException $e) { $errorMsg = $e->getMessage(); }
			}

		return $errorMsg;
	}

	function getLeadersPatrol($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM VODA WHERE OIB=:id");
			$st->execute(array("id" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();

		return $row["IME_PATROLE"];
	}

	function getMaxId()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT ID FROM AKTIVNOST");
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		$max = -1;
		while($row = $st->fetch())
		{
			if ((int)$row["ID"] > $max)
				$max  = (int)$row["ID"];
		}

		return $max;
	}

	function insertActivity($id, $mjesto, $datum, $cijena, $opis, $sirina, $duljina)
	{
		$activityId = $this->getMaxId() + 1;
		$errorMsg = "OK";

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO AKTIVNOST(OIB, MJESTO, DATUM_ODRZAVANJA, OPIS, CIJENA, BROJ_CLANOVA, SIRINA, DUZINA)
			 VALUES (:oib, :mjesto, :datum, :opis, :cijena, :broj_clanova, :sirina, :duzina)");
			$st->execute(array("oib" => $id, "mjesto" => $mjesto, "datum" => $datum,
			"opis" => $opis, "cijena" => $cijena, "broj_clanova" => 1, 'sirina' => $sirina, 'duzina' => $duljina));
		}
		catch(PDOException $e) { $errorMsg = $e->getMessage(); }

		if (strcmp($errorMsg, "OK") === 0) {
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare("INSERT INTO SUDJELUJE_NA(ID_AKTIVNOST, OIB, ULOGA)
				 VALUES (:id_aktivnost, :oib, :uloga)");
				$st->execute(array("id_aktivnost" => $activityId, "oib" => $id, "uloga" => "voda izleta"));
			}
			catch(PDOException $e) { $errorMsg = $e->getMessage(); }
			}

		return [$errorMsg, $activityId];
	}

	function getUsersByPatrol($ime_patrole)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM IZVIDAC WHERE IME_PATROLE=:ime_patrole");
			$st->execute(array("ime_patrole" => $ime_patrole));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = new User($row["OIB"], $row["IME"], $row["PREZIME"], $row["ADRESA"], $row["DATUM_UPISA"],
			$row["IME_PATROLE"], $row["EMAIL"], $row["USERNAME"], $row["PASSWORD_HASH"], $row["ULOGIRAN"],
			$row["SLIKA"]);

		return $arr;
	}

	function getPatrolsLeader($ime_patrole)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT USERNAME FROM VODA, IZVIDAC WHERE VODA.OIB=IZVIDAC.OIB AND
								VODA.IME_PATROLE=:ime_patrole");
			$st->execute(array("ime_patrole" => $ime_patrole));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();

		return $row["USERNAME"];
	}

	function getNews()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM OBAVIJESTI");
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = ["id" => $row["ID"], "sadrzaj" => $row["SADRZAJ"], "naslov" => $row["NASLOV"],
						"datum" => $row["DATUM"], "autor" => $this->getUserById($row["OIB"])->username];

		return $arr;
	}

	function insertNews($sadrzaj, $naslov, $datum, $autor)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO OBAVIJESTI(SADRZAJ, NASLOV, DATUM, OIB)
			 VALUES (:sadrzaj, :naslov, :datum, :oib)");
			$st->execute(array("sadrzaj" => $sadrzaj, "naslov" => $naslov, "datum" => $datum,
			"oib" => $autor));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
	}

	function getCommentsById($id_obavijesti)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM KOMENTAR WHERE ID_OBAVIJEST=:id_obavijest");
			$st->execute(array("id_obavijest" => $id_obavijesti));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = ["id_komentar" => $row["ID_KOMENTAR"], "sadrzaj" => $row["SADRZAJ"],
						"datum" => $row["DATUM"], "autor" => $this->getUserById($row["OIB"])->username,
						"id_obavijest" => $row["ID_OBAVIJEST"]];

		return $arr;
	}

	function getNewsIds()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT ID FROM OBAVIJESTI");
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = $row["ID"];

		return $arr;
	}

	function getComments()
	{
		$newsIds = $this->getNewsIds();
		$komentari = [];

		foreach ($newsIds as $newsId) {
			$komentar = [];
			$komentar["id"] = $newsId;
			$komentar["komentari"] = $this->getCommentsById($newsId);
			$komentari[] = $komentar;
		}

		return $komentari;
	}

	function addComment($sadrzaj, $datum, $oib, $id_obavijest)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO KOMENTAR(SADRZAJ, DATUM, OIB, ID_OBAVIJEST)
			 VALUES (:sadrzaj, :datum, :oib, :id_obavijest)");
			$st->execute(array("sadrzaj" => $sadrzaj, "datum" => $datum, "oib" => $oib,
			"id_obavijest" => $id_obavijest));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
	}
	
	function getReadMessages($oib1, $oib2) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT BROJ_PROCITANIH FROM PROCITANO WHERE OIB1=:oib1 AND OIB2=:oib2");
			$st->execute(array("oib1" => $oib1, "oib2" => $oib2));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if ($row)
			return $row["BROJ_PROCITANIH"];
		else
			return false;
	}
	
	function updateReadMessages($oib1, $oib2, $state) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM PROCITANO WHERE OIB1=:oib1 AND OIB2=:oib2");
			$st->execute(array("oib1" => $oib1, "oib2" => $oib2));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
		
		if ($st->fetch()) {
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare("UPDATE PROCITANO SET BROJ_PROCITANIH=:state WHERE OIB1=:oib1 AND OIB2=:oib2");
				$st->execute(array("state" => $state, "oib1" => $oib1, "oib2" => $oib2));
			}
			catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
		} else {
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare("INSERT INTO PROCITANO(OIB1, OIB2, BROJ_PROCITANIH)
			 						VALUES (:oib1, :oib2, :state)");
				$st->execute(array("oib1" => $oib1, "oib2" => $oib2, "state" => $state));
			}
			catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
		}
	}
};

?>

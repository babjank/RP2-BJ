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
			return new User($row["OIB"], $row["USERNAME"], $row["PASSWORD_HASH"], $row["EMAIL"], $row["ULOGIRAN"], $row["IME_PATROLE"]);
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
			return new User($row["OIB"], $row["USERNAME"], $row["PASSWORD_HASH"], $row["EMAIL"], $row["ULOGIRAN"], $row["IME_PATROLE"]);
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


	function getAllTroops()
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
			$arr[] = new Troop($row["IME_PATROLE"], $row["RAZRED"], $row["STUPANJ_ZNANJA"], $row["ID_RADIONICA"]);
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
			return new Activity($row["ID"], $row["ID_IZVIDAC"], $row["DATUM_ODRZAVANJA"], $row["MJESTO"], $row["CIJENA"], $row["BROJ_CLANOVA"]);
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
			$arr[] = new Activity($row["ID"], $row["ID_IZVIDAC"], $row["DATUM_ODRZAVANJA"], $row["MJESTO"], $row["CIJENA"], $row["BROJ_CLANOVA"]);
		}

		return $arr;
	}

	function getAcitivtiesByMemberId($id_user)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM SUDJELUJE_NA WHERE ID_IZVIDAC=:id_user");
			$st->execute(array("id_user" => $id_user));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			$activity = $this->getActivityById($row["ID_AKTIVNOST"]);
			$arr[] = new Activity($activity->id, $sctivity->id_izvidac, $activity->datum, $activity->mjesto,
			$activity->cijena, $activity->broj_clanova);
		}

		return $arr;
	}

	function getMembersByActivityId($id_activity)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM SUDJELUJE_NA WHERE ID_AKTIVNOST=:id_activity");
			$st->execute(array("id_project" => $id_project));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = new Member($row["ID"], $row["ID_AKTIVNOST"], $row["ID_IZVIDAC"], $row["ULOGA"]);

		return $arr;
	}

};

?>

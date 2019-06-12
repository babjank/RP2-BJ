<?php

require_once "db.class.php";
require_once "user.class.php";
require_once "project.class.php";
require_once "member.class.php";

class TeamUpService
{
	function getUserByUsername($username)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_users WHERE username=:username");
			$st->execute(array("username" => $username));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new User($row["id"], $row["username"], $row["password_hash"], $row["email"],
			$row["registration_sequence"], $row["has_registered"]);
	}
	
	function getUserById($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_users WHERE id=:id");
			$st->execute(array("id" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new User($row["id"], $row["username"], $row["password_hash"], $row["email"],
			$row["registration_sequence"], $row["has_registered"]);
	}


	function getProjectById($id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_projects WHERE id=:id");
			$st->execute(array("id" => $id));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$row = $st->fetch();
		if($row === false)
			return null;
		else
			return new Project($row["id"], $row["id_user"], $row["title"], $row["abstract"],
			$row["number_of_members"], $row["status"]);
	}


	function getAllProjects()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_projects");
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			$arr[] = new Project($row["id"], $row["id_user"], $row["title"], $row["abstract"],
			$row["number_of_members"], $row["status"]);
		}

		return $arr;
	}
	
	function getProjectsByMemberId($id_user)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_members WHERE id_user=:id_user AND 
			(member_type=:type1 OR member_type=:type2 OR member_type=:type3)");
			$st->execute(array("id_user" => $id_user, "type1" => "member", "type2" => "application_accepted",
			"type3" => "invitation_accepted"));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			$project = $this->getProjectById($row["id_project"]);
			$arr[] = new Project($project->id, $project->id_user, $project->title, $project->abstract,
			$project->number_of_members, $project->status);
		}

		return $arr;
	}
	
	function getMaxId($dbName)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT id FROM dz2_" . $dbName);
			$st->execute();
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		$max = -1;
		while($row = $st->fetch())
		{
			if ((int)$row["id"] > $max)
				$max  = (int)$row["id"];
		}

		return $max;
	}
	
	function insertProject($id_user, $title, $abstract, $number_of_members)
	{
		$id = $this->getMaxId("projects") + 1;
		$errorMsg = "OK";
		
		if ($number_of_members > 1)
			$status = "open";
		else
			$status = "closed";
		
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO dz2_projects(id, id_user, title, abstract, number_of_members, status)
			 VALUES (:id, :id_user, :title, :abstract, :number_of_members, :status)");
			$st->execute(array("id" => $id, "id_user" => $id_user, "title" => $title, "abstract" => $abstract,
			"number_of_members" => $number_of_members, "status" => $status));
		}
		catch(PDOException $e) { $errorMsg = $e->getMessage(); }
		
		$this->insertMember($id, $_SESSION["id"], "member");
		
		return [$errorMsg, $id];
	}
	
	function getMembersByProjectId($id_project)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_members WHERE id_project=:id_project AND 
			(member_type=:type1 OR member_type=:type2 OR member_type=:type3)");
			$st->execute(array("id_project" => $id_project, "type1" => "member", "type2" => "application_accepted",
			"type3" => "invitation_accepted"));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = new Member($row["id"], $row["id_project"], $row["id_user"], $row["member_type"]);

		return $arr;
	}
	
	function countMembers($id_project)
	{
		$membersList = $this->getMembersByProjectid($id_project);
		
		$cnt = 0;
		foreach ($membersList as $member) {
			if ((strcmp($member->member_type, "application_accepted") === 0) || 
			(strcmp($member->member_type, "member") === 0) || 
			(strcmp($member->member_type, "invitation_accepted") === 0))
				++$cnt;
		}
			
		return $cnt;
	}
	
	function insertMember($id_project, $id_user, $member_type)
	{
		$errorMsg = 'OK';
		
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO dz2_members(id_project, id_user, member_type)
			 VALUES (:id_project, :id_user, :member_type)");
			$st->execute(array("id_project" => $id_project, "id_user" => $id_user,
			"member_type" => $member_type));
		}
		catch(PDOException $e) { $errorMsg = $e->getMessage(); }
		
		return $errorMsg;
	}
	
	function getApplicationsByMemberId($id_user) 
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_members WHERE id_user=:id_user AND 
			(member_type=:type1 OR member_type=:type2 OR member_type=:type3)");
			$st->execute(array("id_user" => $id_user, "type1" => "application_pending", "type2" => "application_accepted",
			"type3" => "application_rejected"));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		$typeList = [];
		while($row = $st->fetch())
		{
			$project = $this->getProjectById($row["id_project"]);
			$arr[] = new Project($project->id, $project->id_user, $project->title, $project->abstract,
			$project->number_of_members, $project->status);
			$typeList[$project->id] = $row["member_type"];
		}

		return [$arr, $typeList];
	}
	
	function getPendingAppsByProjectId($id_project) 
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_members WHERE id_project=:id_project AND 
			member_type=:member_type");
			$st->execute(array("id_project" => $id_project, "member_type" => "application_pending"));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
			$arr[] = new Member($row["id"], $row["id_project"], $row["id_user"], $row["member_type"]);

		return $arr;
	}
	
	function getInvitationsByMemberId($id_user)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_members WHERE id_user=:id_user AND 
			member_type=:member_type");
			$st->execute(array("id_user" => $id_user, "member_type" => "invitation_pending"));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		$arr = array();
		while($row = $st->fetch())
		{
			$project = $this->getProjectById($row["id_project"]);
			$arr[] = new Project($project->id, $project->id_user, $project->title, $project->abstract,
			$project->number_of_members, $project->status);
		}

		return $arr;
	}
	
	function changeMemberType($id_project, $id_user, $member_type)
	{
		$errorMsg = "OK";
		
		if (strcmp($member_type, "application_accepted") === 0 || strcmp($member_type, "invitation_accepted") === 0) {
			$membersCnt = $this->countMembers($id_project);
			$projectInfo = $this->getProjectById($id_project);
			if ($membersCnt === (int)$projectInfo->number_of_members) {
				$errorMsg = "Kvota za projekt već je popunjena.";
				return $errorMsg;
			}
		}
		
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("UPDATE dz2_members SET member_type=:member_type WHERE id_project=:id_project AND
			id_user=:id_user");
			$st->execute(array("id_project" => $id_project, "id_user" => $id_user,
			"member_type" => $member_type));
		}
		catch(PDOException $e) { $errorMsg = $e->getMessage(); }
		
		if (strcmp($member_type, "application_accepted") === 0 || strcmp($member_type, "invitation_accepted") === 0) {
			$membersCnt = $this->countMembers($id_project);
			if ($membersCnt === (int)$projectInfo->number_of_members) {
				try
				{
					$st2 = $db->prepare("UPDATE dz2_projects SET status=:status WHERE id=:id");
					$st2->execute(array("id" => $id_project, "status" => "closed"));
				}
				catch(PDOException $e) { $errorMsg .= ", " . $e->getMessage(); }
			}
		}
		
		return $errorMsg;
	}
	
	function MemberAppInvitation($id_project, $id_user)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_members WHERE id_project=:id_project AND 
			id_user=:id_user AND member_type!=:type1 AND member_type!=:type2");
			$st->execute(array("id_project" => $id_project, "id_user" => $id_user, 
			"type1" => "invitation_rejected", "type2" => "application_rejected"));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		if ($st->fetch() !== false)
			return true;
		return false;
	}
	
	function insertUser($username, $password, $email)
	{
		$reg_seq = "";
		for($i = 0 ; $i < 20; ++$i)
			$reg_seq .= chr(rand(0, 25) + ord("a"));
		
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("INSERT INTO dz2_users(username, password_hash, email, registration_sequence, has_registered)
			 VALUES (:username, :password_hash, :email, :registration_sequence, 0)");
			$st->execute(array("username" => $username, "password_hash" => password_hash($password, PASSWORD_DEFAULT),
			"email" => $email, "registration_sequence" => $reg_seq));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
	}
	
	function getUserByReqSeq($reg_seq) 
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("SELECT * FROM dz2_users WHERE registration_sequence=:registration_sequence");
			$st->execute(array("registration_sequence" => $reg_seq));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }

		return $st->rowCount();
	}
	
	function setHasRegistered($reg_seq)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare("UPDATE dz2_users SET has_registered=1 WHERE registration_sequence=:registration_sequence");
			$st->execute(array("registration_sequence" => $reg_seq));
		}
		catch(PDOException $e) { exit("PDO error " . $e->getMessage()); }
	}
};

?>
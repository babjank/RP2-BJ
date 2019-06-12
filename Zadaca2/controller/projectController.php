<?php 

require_once "model/teamupservice.class.php";

class ProjectController
{
	public function index() 
	{
		$tus = new TeamUpService();

		$projectList = $tus->getAllProjects();
		$userList = [];
		
		foreach ($projectList as $project) {
			$id = $project->id_user;
			$user = $tus->getUserById($id);
			$userList[$id] = $user->username; 
		}

		$byUser = false;
		require_once "view/project_index.php";
	}

	public function myprojects() 
	{
		$tus = new TeamUpService();

		$projectList = $tus->getProjectsByMemberId($_SESSION["id"]);
		$userList = [];
		
		foreach ($projectList as $project) {
			$id = $project->id_user;
			$user = $tus->getUserById($id);
			$userList[$id] = $user->username;
		}
		
		$byUser = true;
		require_once "view/project_index.php";
	}
	
	public function show() 
	{
		$tus = new TeamUpService();

		if (!isset($_GET["id_project"]) || !preg_match("/^[0-9]+$/", $_GET["id_project"]))
		{
			header("Location: teamup.php?rt=project");
			exit();
		}

		$projectInfo = $tus->getProjectById($_GET["id_project"]);
		$memberList = $tus->getMembersByProjectId($projectInfo->id);
		
		$userList = [];
		$isaMember = false;
		
		foreach ($memberList as $member) {
			$id = $member->id_user;
			$user = $tus->getUserById($id);
			$userList[$id] = $user->username;
			if (strcmp($member->id_user, $_SESSION["id"]) === 0)
				$isaMember = true;
		}

		require_once "view/project_show.php";
	}
	
	public function showmine()
	{
		$tus = new TeamUpService();

		if (!isset($_GET["id_project"]) || !preg_match("/^[0-9]+$/", $_GET["id_project"]))
		{
			header("Location: teamup.php?rt=project");
			exit();
		}

		$projectInfo = $tus->getProjectById($_GET["id_project"]);
		$memberList = $tus->getMembersByProjectId($projectInfo->id);
		$pendingApps = $tus->getPendingAppsByProjectId($projectInfo->id);
		
		$userList = [];
		
		foreach ($memberList as $member) {
			$id = $member->id_user;
			$user = $tus->getUserById($id);
			$userList[$id] = $user->username;
		}
		
		$pendUserList = [];
		
		foreach ($pendingApps as $pendingApp) {
			$id = $pendingApp->id_user;
			$pendUser = $tus->getUserById($id);
			$pendUserList[$id] = $pendUser->username;
		}
		
		require_once "view/project_showmine.php";
	}
	
	public function apply()
	{
		$tus = new TeamUpService();
		
		if (!isset($_GET["id_project"]) || !preg_match("/^[0-9]+$/", $_GET["id_project"]))
		{
			header("Location: teamup.php?rt=project");
			exit();
		}
		
		$id_project = $_GET["id_project"];
		if ($tus->MemberAppInvitation($id_project, $_SESSION["id"]))
			$errorMsg = "Već ste se prijavili ili ste pozvani.";
		else
			$errorMsg = $tus->insertMember($id_project, $_SESSION["id"], "application_pending");
		
		require_once "view/project_apply.php";
	}
	
	public function newproject()
	{
		require_once "view/project_new.php";
	}
	
	public function newprojectinput()
	{
		$tus = new TeamUpService();
		
		$errorMsg = "NOT_SET";
		
		if (isset($_POST["title"]) && isset($_POST["abstract"]) && isset($_POST["number_of_members"]) &&
		(strcmp($_POST["title"], "") !== 0) && (strcmp($_POST["number_of_members"], "") !== 0)) {
			$retVal = $tus->insertProject($_SESSION["id"], $_POST["title"], $_POST["abstract"], $_POST["number_of_members"]);
			$errorMsg = $retVal[0];
			$id_project = $retVal[1];
		}
		
		require_once "view/project_newinput.php";
	}
	
	public function applications()
	{
		$tus = new TeamUpService();
		
		$apps = $tus->getApplicationsByMemberId($_SESSION["id"]);
		$projectList = $apps[0];
		$typeList = $apps[1];
		$userList = [];
		
		foreach ($projectList as $project) {
			$id = $project->id_user;
			$user = $tus->getUserById($id);
			$userList[$id] = $user->username;
		}
		
		require_once "view/project_applications.php";
	}
	
	public function invitations()
	{
		$tus = new TeamUpService();
		
		$projectList = $tus->getInvitationsByMemberId($_SESSION["id"]);
		$userList = [];
		
		foreach ($projectList as $project) {
			$id = $project->id_user;
			$user = $tus->getUserById($id);
			$userList[$id] = $user->username;
		}
		
		require_once "view/project_invitations.php";
	}
	
	public function review()
	{
		$tus = new TeamUpService();
		
		if (!isset($_GET["id_user"]) || !preg_match("/^[0-9]+$/", $_GET["id_user"])
		 || !isset($_GET["id_project"]) || !preg_match("/^[0-9]+$/", $_GET["id_project"]) 
		 || !(isset($_POST["accept"]) || isset($_POST["reject"])))
		{
			header("Location: teamup.php?rt=project/myprojects");
			exit();
		}
	
		$id_project = $_GET["id_project"];
		$id_user = $_GET["id_user"];
		if (isset($_POST["accept"]))
			$member_type = "application_accepted";
		else
			$member_type = "application_rejected";
		$errorMsg = $tus->changeMemberType($id_project, $id_user, $member_type);
		
		$byUser = true;
		require_once "view/project_review.php";
	}
	
	public function react()
	{
		$tus = new TeamUpService();
		
		if (!isset($_GET["id_project"]) || !preg_match("/^[0-9]+$/", $_GET["id_project"]) 
		 || !(isset($_POST["accept"]) || isset($_POST["reject"])))
		{
			header("Location: teamup.php?rt=project/invitations");
			exit();
		}
	
		$id_project = $_GET["id_project"];
		if (isset($_POST["accept"]))
			$member_type = "invitation_accepted";
		else
			$member_type = "invitation_rejected";
		$errorMsg = $tus->changeMemberType($id_project, $_SESSION["id"], $member_type);
		
		$byUser = false;
		require_once "view/project_review.php";
	}
	
	public function invite()
	{
		$tus = new TeamUpService();
		
		if (!isset($_POST["invitedUser"]) || !isset($_GET["id_project"]) || !preg_match("/^[0-9]+$/", $_GET["id_project"]))
		{
			header("Location: teamup.php?rt=project/myprojects");
			exit();
		}
	
		$id_project = $_GET["id_project"];
		$id_user = ($tus->getUserByUsername(strtolower($_POST["invitedUser"])))->id;
		if ($tus->MemberAppInvitation($id_project, $id_user))
			$errorMsg = "Korisnik je već član, pozvan ili je poslao zahtjev.";
		else
			$errorMsg = $tus->insertMember($id_project, $id_user, "invitation_pending");
		
		$byUser = true;
		require_once "view/project_review.php";
	}
}; 

?>

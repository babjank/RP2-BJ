<?php require_once "view/_header.php";

echo "<div>Author: <span style='color:white; background-color:#FF5F5F;'>" . ucfirst($userList[$projectInfo->id_user]) . "</span>";
echo "<h3>" . $projectInfo->title . "</h3>Description<br>";
echo $projectInfo->abstract . "<br>Members: ";

foreach ($memberList as $member) {
	if (strcmp($member->id_user, $projectInfo->id_user) !== 0)
		echo "<span style='color:white; background-color:#FF5F5F;'>" . ucfirst($userList[$member->id_user]) . "</span> ";
}

echo "(target team size: " . $projectInfo->number_of_members . ")<br>";

if (strcmp($projectInfo->id_user, $_SESSION["id"]) === 0) {
	foreach ($pendingApps as $pendingApp) {
		echo ucfirst($pendUserList[$pendingApp->id_user]);
		echo "<form action='teamup.php?rt=project/review&id_project=". $projectInfo->id . 
		"&id_user=" . $pendingApp->id_user . "' method='POST'>";
		echo "<button type='submit' name='accept'>Accept application!</button> ";
		echo "<button type='submit' name='reject'>Reject application!</button>";
		echo "</form>";
	}
	
	if (strcmp($projectInfo->status, "open") === 0) {
		echo "<form action='teamup.php?rt=project/invite&id_project=". $projectInfo->id . "' method='POST'>";
		echo "Send an invitation to: <input type='text' name='invitedUser'> ";
		echo "<button type='submit'>Invite!</button>";
		echo "</form>";
	}
}
echo "</div>";

require_once "view/_footer.php"; ?>
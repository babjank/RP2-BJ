<?php require_once "view/_header.php";

echo "<div>Author: <span style='color:white; background-color:#FF5F5F;'>" . ucfirst($userList[$projectInfo->id_user]) . "</span>";
echo "<h3>" . $projectInfo->title . "</h3>Description<br>";
echo $projectInfo->abstract . "<br>Members: ";

foreach ($memberList as $member) {
	if (strcmp($member->id_user, $projectInfo->id_user) !== 0)
		echo "<span style='color:white; background-color:#FF5F5F;'>" . ucfirst($userList[$member->id_user]) . "</span> ";
}

echo "(target team size: " . $projectInfo->number_of_members . ")<br>";

if (!$isaMember && (strcmp($projectInfo->status, "open") === 0)) {
	echo "<form action='teamup.php?rt=project/apply&id_project=" . $projectInfo->id . "' method='POST'>";
	echo "<button type='submit'>Apply for this project!</button>";
	echo "</form>";
}
echo "</div>";

require_once "view/_footer.php"; ?>
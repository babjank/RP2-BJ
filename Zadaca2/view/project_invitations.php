<?php require_once "view/_header.php"; ?>

<?php 
	foreach($projectList as $project)
	{
		$user = $userList[$project->id_user];
		echo "<div>" . "Author: " . ucfirst($user) . " (status: " . $project->status . ")<br>";
		echo "<h3><a href='teamup.php?rt=project/show&id_project=". $project->id . "'>" . $project->title . "</a></h3>";
		echo "<form action='teamup.php?rt=project/react&id_project=". $project->id . 
		"' method='POST'>";
		echo "<button type='submit' name='accept'>Accept invitation!</button> ";
		echo "<button type='submit' name='reject'>Reject invitation!</button>";
		echo "</form>";
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>
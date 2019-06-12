<?php require_once "view/_header.php"; ?>

<?php 
	foreach($projectList as $project)
	{
		if (strcmp($project->status, "open") === 0)
			$color = "#67C076";
		else
			$color = "#FF5F5F";
		$user = $userList[$project->id_user];
		echo "<div>" . "Author: " . ucfirst($user) . " (status: <span style='color:white; background-color:" . $color .
			    ";'>" . $project->status . "</span>)<br>";
		echo "<h4>";
		if ($byUser && (strcmp($project->id_user, $_SESSION["id"]) === 0))
			echo "<span style='background-color:#FFFFBF'>";
		if ($byUser)
			echo "<a href='teamup.php?rt=project/showmine&id_project=". $project->id . "'>" . $project->title . "</a>";
		else
			echo "<a href='teamup.php?rt=project/show&id_project=". $project->id . "'>" . $project->title . "</a>";
		if ($byUser && (strcmp($project->id_user, $_SESSION["id"]) === 0))
			echo "</span>";
		echo "</h4>";
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>
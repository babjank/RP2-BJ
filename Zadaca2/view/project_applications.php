<?php require_once "view/_header.php"; ?>

<?php 
	foreach($projectList as $project)
	{
		$user = $userList[$project->id_user];
		echo "<div>" . "Author: " . ucfirst($user) . " (status: " . $project->status . ")<br>";
		echo "<h3><a href='teamup.php?rt=project/show&id_project=". $project->id . "'>" . $project->title . "</a></h3>";
		echo "Your application ";
		if (strcmp($typeList[$project->id], "application_accepted") === 0)
			echo "has been <span style='color:white; background-color:#67C076;'>accepted</span>.";
		else if (strcmp($typeList[$project->id], "application_rejected") === 0)
			echo "has been rejected.";
		else
			echo "is still pending.";
		echo "</div>";
	}
?>

<?php require_once "view/_footer.php"; ?>
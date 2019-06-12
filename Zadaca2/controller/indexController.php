<?php 

class IndexController
{
	public function index() 
	{
		// Samo preusmjeri na login podstranicu.
		if (!isset($_SESSION["username"]))
			header("Location: teamup.php?rt=login");
		else
			header("Location: teamup.php?rt=project");
	}
}; 

?>

<?php

require_once "model/service.class.php";

class LoginController
{
	public function index()
	{
		require_once "view/login_index.php";
	}

	public function authentication()
	{
		$tus = new Service();

		if (isset($_POST["signup"])) {
			header("Location: scoutbook.php?rt=login/registerform");
			exit();
		}

		if (isset($_POST["username"]) && isset($_POST["password"])) {
			$user = $tus->getUserByUsername($_POST["username"]);

			if ($user === null)
				$message = "Korisnik s tim imenom ne postoji.";
			else if (password_verify($_POST["password"], $user->password_hash)) {
				$_SESSION["username"] = $user->username;
				$_SESSION["id"] = $user->id;
				$_SESSION["voda"] = $tus->checkIfLeaderById($_SESSION["id"]);
				if ($user->ulogiran === "0")
					header("Location: scoutbook.php?rt=login/prvilogin");
				else
					header("Location: scoutbook.php?rt=troop");
				exit();
			}
			else if (!password_verify($_POST["password"], $user->password_hash))
				$message = "Lozinka nije ispravna.";
		}

		if (!isset($message))
			$message = "Neuspješan login.";
		require_once "view/login_index.php";
	}
	
	public function prvilogin()
	{
		require_once "view/prvilogin_index.php";
	}
	
	public function promijeniPodatke()
	{	
		$tus = new Service();
		
		if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["password2"]) | 
			!isset($_FILES["fileToUpload"]) || strcmp($_POST["username"], "") === 0 ||
			strcmp($_POST["password"], "") === 0) {
			$message = "Niste unijeli sve potrebne podatke.";
			require_once "view/prvilogin_index.php";
			return;
		}
		
		if (strcmp($_POST["password"], $_POST["password2"]) !== 0) {
			$message = "Lozinke se ne poklapaju.";
			require_once "view/prvilogin_index.php";
			return;
		}
		
		else {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if(isset($_POST["submit"])) {
    			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    			if ($check !== false) {
        			$uploadOk = 1;
    			} else {
        			$message = "File is not an image.";
        			$uploadOk = 0;
    			}
			}
			if ($_FILES["fileToUpload"]["size"] > 500000) {
    			$message = "Sorry, your file is too large.";
    			$uploadOk = 0;
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
    			$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    			$uploadOk = 0;
			}
			if ($uploadOk == 0) {
   				$message = "Sorry, your file was not uploaded.";
   				require_once "view/prvilogin_index.php";
			return;
			} else {
    			if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        			$message = "Sorry, there was an error uploading your file.";
        			require_once "view/prvilogin_index.php";
					return;
   				}
			}
			
			$tus->changeUserInfo($_SESSION["username"], $_POST["username"],
				password_hash($_POST["password"], PASSWORD_DEFAULT), $_FILES["fileToUpload"]["name"]);
			$_SESSION["username"] = $_POST["username"];
			
			header("Location: scoutbook.php?rt=troop");
			exit();
    	}
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		header("Location: scoutbook.php");
	}
};

?>

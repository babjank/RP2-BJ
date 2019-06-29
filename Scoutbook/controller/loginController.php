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
			else if (password_verify($_POST["password"], $user->password_hash)) { // && (strcmp($user->has_registered, 1) === 0)
				$_SESSION["username"] = $user->username;
				$_SESSION["id"] = $user->id;
				header("Location: scoutbook.php?rt=troop");
				exit();
			}
			else if (!password_verify($_POST["password"], $user->password_hash))
				$message = "Lozinka nije ispravna.";
			/*else if (strcmp($user->has_registered, 0) === 0)
				$message = "Korisnik s tim imenom se nije još registrirao. Provjerite e-mail.";*/
		}

		if (!isset($message))
			$message = "Neuspješan login.";
		require_once "view/login_index.php";
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		header("Location: scoutbook.php");
	}

};

?>

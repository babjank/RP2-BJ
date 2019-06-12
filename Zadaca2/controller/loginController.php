<?php

require_once "model/teamupservice.class.php";

class LoginController
{
	public function index() 
	{
		require_once "view/login_index.php";
	}
	
	public function authentication()
	{
		$tus = new TeamUpService();
		
		if (isset($_POST["signup"])) {
			header("Location: teamup.php?rt=login/registerform");
			exit();
		}
				
		if (isset($_POST["username"]) && isset($_POST["password"])) {
			$user = $tus->getUserByUsername($_POST["username"]);
			
			if ($user === null)
				$message = "Korisnik s tim imenom ne postoji.";
			else if (password_verify($_POST["password"], $user->password_hash) && (strcmp($user->has_registered, 1) === 0)) {
				$_SESSION["username"] = $user->username;
				$_SESSION["id"] = $user->id;
				header("Location: teamup.php?rt=project");
				exit();
			}
			else if (!password_verify($_POST["password"], $user->password_hash))
				$message = "Lozinka nije ispravna.";
			else if (strcmp($user->has_registered, 0) === 0)
				$message = "Korisnik s tim imenom se nije još registrirao. Provjerite e-mail.";
		}
		
		if (!isset($message))
			$message = "Neuspješan login.";
		require_once "view/login_index.php";
	}
	
	public function logout()
	{
		session_unset();
		session_destroy();
		header("Location: teamup.php");
	}
	
	public function registerform()
	{
		if (isset($_GET["message"]))
			$message = $_GET["message"];
		require_once "view/register_index.php";
	}
	
	public function register()
	{
		if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"])) {
			$message = "Trebate unijeti korisničko ime, password i e-mail adresu.";
			header("Location: teamup.php?rt=login/registerform&message=" . $message);
			exit();
		}	
		

		if	(!preg_match("/^[A-Za-z]{3,10}$/", $_POST["username"])) {
			$message = "Korisničko ime treba imati između 3 i 10 slova.";
			header("Location: teamup.php?rt=login/registerform&message=" . $message);
			exit();
		}
		
		else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$message = "E-mail adresa nije ispravna.";
			header("Location: teamup.php?rt=login/registerform&message=" . $message);
			exit();
		}
		
		$tus = new TeamUpService();
		$user = $tus->getUserByUsername($_POST["username"]);
		if ($user !== null) {
			$message = "Korisnik s tim imenom već postoji u bazi.";
			header("Location: teamup.php?rt=login/registerform&message=" . $message);
			exit();
		}
			
		$tus->insertUser($_POST["username"], $_POST["password"], $_POST["email"]);
		
		$to       = $_POST["email"];
		$subject  = "Registracijski mail";
		$message  = "Poštovani " . $_POST["username"] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
		$message .= "http://" . $_SERVER["SERVER_NAME"] . htmlentities(dirname($_SERVER["PHP_SELF"])) . 
		'/../teamup.php?rt=login/confirmation&niz=' . $reg_seq . "\n";
		$headers  = "From: rp2@studenti.math.hr" . "\r\n" .
		            "Reply-To: rp2@studenti.math.hr" . "\r\n" .
		            "X-Mailer: PHP/" . phpversion();

		$isOK = mail($to, $subject, $message, $headers);
		
		if (!$isOK)
			exit("Greška: ne mogu poslati mail.");
		
		require_once "view/register_success.php";
	}
	
	function confirmation()
	{
		if (!isset($_GET["niz"]) || !preg_match("/^[a-z]{20}$/", $_GET["niz"]))
			exit("Nešto ne valja s nizom.");
			
		$tus = new TeamUpService();
		$cnt = $tus->getUserByReqSeq($_GET["niz"]);
		if ($cnt !== 1)
			exit("Taj registracijski niz ima " . $cnt . "korisnika, a treba biti točno 1 takav.");
		
		$tus->setHasRegistered($_GET["niz"]);
		
		require_once "view/register_success.php";
	}
}; 

?>
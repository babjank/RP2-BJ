<?php

require_once "model/service.class.php";

class LoginController
{
	public function index()
	{
		require_once "view/login_index.php"; // Prikazuje se klasična forma za ulogiravanje
	}

	public function authentication() // Provjera podataka unesenih u formu za ulogiravanje
	{
		$tus = new Service();

		if (isset($_POST["username"]) && isset($_POST["password"])) {
			$user = $tus->getUserByUsername($_POST["username"]); // Dohvaćanje korisnika s upisanim usernameom iz baze podataka

			if ($user === null)
				$message = "Korisnik s tim imenom ne postoji.";
			else if (password_verify($_POST["password"], $user->password_hash)) {
				$_SESSION["username"] = $user->username;
				$_SESSION["id"] = $user->id;
				$_SESSION["voda"] = $tus->checkIfLeaderById($_SESSION["id"]);
				// Korisnik je uspješno ulogiran, ako mu je to prvi put da se ulogirao, preusmjerava ga se na formu za unos preferiranih podataka. Inače, preusmjerava ga se na naslovnu stranicu, odjeljak s obavijestima
				if ($user->ulogiran === "0")
					header("Location: scoutbook.php?rt=login/prvilogin");
				else
					header("Location: scoutbook.php?rt=troop/news");
				exit();
			}
			else if (!password_verify($_POST["password"], $user->password_hash))
				$message = "Lozinka nije ispravna.";
		}

		// U slučaju neuspješnog ulogiravanja, korisnik ponovno vidi formu za login, uz poruku o grešci koja se dogodila prilikom prethodnog ulogiravanja
		if (!isset($message))
			$message = "Neuspješan login.";
		require_once "view/login_index.php";
	}
	
	public function prvilogin()
	{
		require_once "view/prvilogin_index.php"; // Forma za unos preferiranih korisničkih podataka
	}
	
	public function promijeniPodatke() // Funkcija koja pokreće promjenu korisničkih podataka ulogiranog korisnika iz defaultnih u one koje je unio u formu na view/prvilogin_index.php
	{	
		$tus = new Service();
		
		// Ukoliko je nešto pošlo po zlu (nisu uneseni svi traženi podaci, unesene se lozinke ne poklapaju), ponovno se prikazuje ista forma, zajedno s porukom o grešci
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
		
		// Uneseni su svi podaci i lozinke se poklapaju, treba provjeriti je li sve u redu s poslanom slikom (je li zbilja slika, je li odgovarajuće veličine i formata) i, ako jest, pohraniti je
		else {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			if (isset($_POST["submit"])) {
    			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    			if ($check !== false) {
        			$uploadOk = 1;
    			} else {
        			$message = "File nije slika.";
        			$uploadOk = 0;
    			}
			}
			if ($_FILES["fileToUpload"]["size"] > 500000) {
    			$message = "Tvoj je file prevelik.";
    			$uploadOk = 0;
			}
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
    			$message = "Dozvoljeni su samo JPG, JPEG, PNG i GIF formati.";
    			$uploadOk = 0;
			}
			if ($uploadOk == 0) {
   				$message = "Tvoj file nije bio uploadan.";
   				require_once "view/prvilogin_index.php";
			return;
			} else {
    			if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        			$message = "Dogodila se greška prilikom uploadanja filea.";
        			require_once "view/prvilogin_index.php";
					return;
   				}
			}
			
			// Sve je u redu s poslanim podacima (uključujući sliku, koja je uspješno uploadana), mijenjamo podatke o korisniku u bazi podataka
			$tus->changeUserInfo($_SESSION["username"], $_POST["username"],
				password_hash($_POST["password"], PASSWORD_DEFAULT), $_FILES["fileToUpload"]["name"]);
			$_SESSION["username"] = $_POST["username"];
			
			// Preusmjeravamo korisnika na naslovnicu, tj. odjeljak s obavijestima
			header("Location: scoutbook.php?rt=troop/news");
			exit();
    	}
	}

	public function logout() // Funkcija čija je svrha odlogirati korisnika
	{
		session_unset();
		session_destroy();
		header("Location: scoutbook.php");
	}
};

?>
